<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Notifications\SecurityIncident;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class DetectBruteForce
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $key = 'suspicious_activity:' . $ip;
        $maxAttempts = 50; // Max requests per minute
        $decayMinutes = 1;

        // Check for suspicious activity (too many requests)
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $this->reportSuspiciousActivity($ip, $request);

            return response()->json([
                'message' => 'Too many requests. Please try again later.',
            ], 429);
        }

        // Increment rate limiter
        RateLimiter::hit($key, $decayMinutes * 60);

        return $next($request);
    }

    /**
     * Report suspicious activity.
     */
    private function reportSuspiciousActivity(string $ip, Request $request): void
    {
        $cacheKey = "reported_suspicious:{$ip}";

        // Only report once per hour to avoid spam
        if (Cache::has($cacheKey)) {
            return;
        }

        Cache::put($cacheKey, true, now()->addHour());

        $incidentData = [
            'type' => 'suspicious_activity',
            'ip' => $ip,
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'email' => null,
            'timestamp' => now()->toISOString(),
            'details' => 'Too many requests from IP address',
        ];

        Log::warning('Suspicious activity detected', $incidentData);

        // Send notification
        $this->sendSecurityNotification($incidentData);
    }

    /**
     * Send security incident notification.
     */
    private function sendSecurityNotification(array $data): void
    {
        try {
            Notification::route('telegram', config('services.telegram.chat_id'))
                ->route('slack', config('services.slack.webhook_url'))
                ->route('mail', config('mail.security_email', config('mail.from.address')))
                ->notify(new SecurityIncident($data));
        } catch (\Exception $e) {
            Log::error('Failed to send security notification', [
                'error' => $e->getMessage(),
                'data' => $data,
            ]);
        }
    }
}
