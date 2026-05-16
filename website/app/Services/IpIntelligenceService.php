<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class IpIntelligenceService
{
    private const CACHE_TTL = 86400; // 24 hours

    public function lookup(string $ip): array
    {
        if (app()->environment('testing') || $this->isPrivateIp($ip)) {
            return $this->localData($ip);
        }

        return Cache::remember("ip_intel:{$ip}", self::CACHE_TTL, fn () => $this->fetchFromApi($ip));
    }

    private function fetchFromApi(string $ip): array
    {
        try {
            $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}", [
                'fields' => 'status,country,countryCode,regionName,city,timezone,isp,org,as,mobile,proxy,hosting',
                'lang'   => 'en',
            ]);

            $data = $response->json();

            if (! $response->successful() || ($data['status'] ?? '') !== 'success') {
                return $this->unknownData();
            }

            return [
                'country'      => $data['country'] ?? 'Unknown',
                'country_code' => $data['countryCode'] ?? '??',
                'region'       => $data['regionName'] ?? 'Unknown',
                'city'         => $data['city'] ?? 'Unknown',
                'timezone'     => $data['timezone'] ?? 'Unknown',
                'isp'          => $data['isp'] ?? 'Unknown',
                'org'          => $data['org'] ?? 'Unknown',
                'asn'          => $data['as'] ?? 'Unknown',
                'is_mobile'    => (bool) ($data['mobile'] ?? false),
                'is_proxy'     => (bool) ($data['proxy'] ?? false),
                'is_hosting'   => (bool) ($data['hosting'] ?? false),
            ];
        } catch (\Throwable) {
            return $this->unknownData();
        }
    }

    /**
     * Compute a threat level from geo signals and attempt count.
     */
    public function threatLevel(array $geo, int $attempts): string
    {
        $score = 0;

        if ($geo['is_proxy'] ?? false)   $score += 3;
        if ($geo['is_hosting'] ?? false) $score += 2;
        if ($attempts >= 20)             $score += 3;
        elseif ($attempts >= 10)         $score += 2;
        elseif ($attempts >= 5)          $score += 1;

        return match (true) {
            $score >= 6 => 'CRITICAL',
            $score >= 4 => 'HIGH',
            $score >= 2 => 'MEDIUM',
            default     => 'LOW',
        };
    }

    /**
     * Convert a two-letter ISO country code to its flag emoji.
     */
    public function flag(string $code): string
    {
        if (strlen($code) !== 2 || $code === '??') {
            return '🏳️';
        }

        $offset = 0x1F1E6 - ord('A');

        return mb_chr(ord(strtoupper($code[0])) + $offset, 'UTF-8')
             . mb_chr(ord(strtoupper($code[1])) + $offset, 'UTF-8');
    }

    /**
     * Build a short human-readable location string.
     */
    public function locationLine(array $geo): string
    {
        $parts = array_filter([$geo['city'] ?? null, $geo['region'] ?? null, $geo['country'] ?? null]);

        return implode(', ', $parts) ?: 'Unknown location';
    }

    /**
     * Tags for VPN / datacenter / mobile signals.
     */
    public function tags(array $geo): array
    {
        $tags = [];

        if ($geo['is_proxy'] ?? false)   $tags[] = '🕵️ VPN/Proxy/TOR';
        if ($geo['is_hosting'] ?? false) $tags[] = '🤖 Datacenter/Bot';
        if ($geo['is_mobile'] ?? false)  $tags[] = '📱 Mobile Network';

        return $tags;
    }

    private function isPrivateIp(string $ip): bool
    {
        foreach (['127.', '::1', '10.', '172.1', '172.2', '172.3', '192.168.'] as $prefix) {
            if (str_starts_with($ip, $prefix)) {
                return true;
            }
        }

        return in_array($ip, ['localhost', '::1'], true);
    }

    private function localData(string $ip): array
    {
        return [
            'country'      => 'Local Network',
            'country_code' => 'LO',
            'region'       => 'Private',
            'city'         => 'Local',
            'timezone'     => 'Local',
            'isp'          => 'Private Network',
            'org'          => 'Private Network',
            'asn'          => 'N/A',
            'is_mobile'    => false,
            'is_proxy'     => false,
            'is_hosting'   => false,
        ];
    }

    private function unknownData(): array
    {
        return [
            'country'      => 'Unknown',
            'country_code' => '??',
            'region'       => 'Unknown',
            'city'         => 'Unknown',
            'timezone'     => 'Unknown',
            'isp'          => 'Unknown',
            'org'          => 'Unknown',
            'asn'          => 'Unknown',
            'is_mobile'    => false,
            'is_proxy'     => false,
            'is_hosting'   => false,
        ];
    }
}
