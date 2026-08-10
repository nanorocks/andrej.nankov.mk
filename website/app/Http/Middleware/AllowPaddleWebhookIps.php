<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class AllowPaddleWebhookIps
{
    private const CACHE_KEY = 'paddle.webhook.ipv4_cidrs';

    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->is(trim((string) config('cashier.path', 'paddle'), '/').'/webhook')
            || ! config('services.paddle.enforce_webhook_ip_allowlist', true)) {
            return $next($request);
        }

        try {
            $cidrs = $this->currentCidrs();
        } catch (ConnectionException|RequestException|RuntimeException $exception) {
            Log::error('Paddle webhook rejected because its IP allowlist is unavailable.', [
                'exception' => $exception::class,
            ]);

            abort(Response::HTTP_SERVICE_UNAVAILABLE, 'Webhook IP allowlist unavailable.');
        }

        if (! $this->contains($request->ip(), $cidrs)) {
            abort(Response::HTTP_FORBIDDEN, 'Webhook source is not allowed.');
        }

        return $next($request);
    }

    /**
     * @return list<string>
     */
    private function currentCidrs(): array
    {
        /** @var array{cidrs?: list<string>, refreshed_at?: int}|null $cached */
        $cached = Cache::get(self::CACHE_KEY);
        $refreshAfter = (int) config('services.paddle.ip_allowlist_refresh_seconds', 3600);

        if ($cached && ($cached['refreshed_at'] ?? 0) >= time() - $refreshAfter) {
            return $cached['cidrs'] ?? [];
        }

        try {
            $response = Http::acceptJson()
                ->timeout(5)
                ->retry(2, 200)
                ->get((string) config('services.paddle.ips_endpoint'))
                ->throw();

            $cidrs = collect($response->json('data.ipv4_cidrs'))
                ->filter(fn (mixed $cidr): bool => is_string($cidr) && $this->isValidIpv4Cidr($cidr))
                ->values()
                ->all();

            if ($cidrs === []) {
                throw new RuntimeException('Paddle returned an empty or invalid IPv4 CIDR list.');
            }

            Cache::forever(self::CACHE_KEY, [
                'cidrs' => $cidrs,
                'refreshed_at' => time(),
            ]);

            return $cidrs;
        } catch (ConnectionException|RequestException|RuntimeException $exception) {
            if (($cached['cidrs'] ?? []) !== []) {
                Log::warning('Using the last successful Paddle webhook IP allowlist.', [
                    'exception' => $exception::class,
                ]);

                return $cached['cidrs'];
            }

            throw $exception;
        }
    }

    private function isValidIpv4Cidr(string $cidr): bool
    {
        [$network, $prefix] = array_pad(explode('/', $cidr, 2), 2, null);

        return filter_var($network, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false
            && ctype_digit((string) $prefix)
            && (int) $prefix >= 0
            && (int) $prefix <= 32;
    }

    /**
     * @param  list<string>  $cidrs
     */
    private function contains(?string $ip, array $cidrs): bool
    {
        $ipValue = $ip ? ip2long($ip) : false;

        if ($ipValue === false) {
            return false;
        }

        foreach ($cidrs as $cidr) {
            [$network, $prefix] = explode('/', $cidr, 2);
            $networkValue = ip2long($network);
            $prefixLength = (int) $prefix;
            $mask = $prefixLength === 0 ? 0 : (-1 << (32 - $prefixLength));

            if ($networkValue !== false && (($ipValue & $mask) === ($networkValue & $mask))) {
                return true;
            }
        }

        return false;
    }
}
