<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Notifications\SecurityIncident;
use App\Services\IpIntelligenceService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class DetectBruteForce
{
    private const MAX_REQUESTS = 50;
    private const DECAY_SECONDS = 60;

    public function __construct(
        private readonly IpIntelligenceService $intel,
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $ip  = $request->ip() ?? '0.0.0.0';
        $key = "suspicious_activity:{$ip}";

        if (RateLimiter::tooManyAttempts($key, self::MAX_REQUESTS)) {
            $this->report($ip, $request);

            return response()->json([
                'message' => 'Too many requests. Please try again later.',
            ], 429);
        }

        RateLimiter::hit($key, self::DECAY_SECONDS);

        return $next($request);
    }

    private function report(string $ip, Request $request): void
    {
        $cacheKey = "reported_suspicious:{$ip}";

        if (Cache::has($cacheKey)) {
            return;
        }

        Cache::put($cacheKey, true, now()->addHour());

        $geo     = $this->intel->lookup($ip);
        $reqsNow = RateLimiter::attempts("suspicious_activity:{$ip}");

        $hostingCtx = $geo['is_proxy']   ? ' via VPN/Proxy'
            : ($geo['is_hosting'] ? ' via Datacenter/Bot' : '');

        $path = $request->path();
        $details = "Rate limit exceeded: {$reqsNow} req/min from {$geo['country']}{$hostingCtx} targeting /{$path}";

        $incidentData = [
            'type'              => 'suspicious_activity',
            'ip'                => $ip,
            'user_agent'        => $request->userAgent(),
            'url'               => $request->fullUrl(),
            'method'            => $request->method(),
            'email'             => null,
            'timestamp'         => now()->toISOString(),
            'details'           => $details,
            'geo'               => $geo,
            'pattern'           => 'High-volume request flood',
            'requests_per_min'  => $reqsNow,
            'threat_level'      => $this->intel->threatLevel($geo, $reqsNow),
        ];

        Log::warning('Suspicious activity detected', $incidentData);
        $this->send($incidentData);
    }

    private function send(array $data): void
    {
        try {
            Notification::route('telegram', config('services.telegram.chat_id'))
                ->route('slack', config('services.slack.webhook_url'))
                ->route('mail', config('mail.security_email', config('mail.from.address')))
                ->notify(new SecurityIncident($data));
        } catch (\Throwable $e) {
            Log::error('Failed to send security notification', [
                'error' => $e->getMessage(),
                'type'  => $data['type'] ?? 'unknown',
            ]);
        }
    }
}
