<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Notifications\SecurityIncident;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;

class FailedLoginListener
{
    /**
     * Handle the event.
     */
    public function handle(Failed $event): void
    {
        $ip = request()->ip();
        $email = $event->credentials['email'] ?? null;

        $this->trackFailedLogin($ip, $email);
        $this->checkForBruteForceAttack($ip, $email);
    }

    /**
     * Track failed login attempts.
     */
    private function trackFailedLogin(string $ip, ?string $email): void
    {
        $ipKey = 'failed_login:ip:' . $ip;
        $emailKey = $email ? 'failed_login:email:' . $email : null;
        $decayMinutes = 15;

        // Track by IP
        RateLimiter::hit($ipKey, $decayMinutes * 60);

        // Track by email if available
        if ($emailKey) {
            RateLimiter::hit($emailKey, $decayMinutes * 60);
        }

        Log::info('Failed login attempt recorded', [
            'ip' => $ip,
            'email' => $email,
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Check for brute force attack patterns.
     */
    private function checkForBruteForceAttack(string $ip, ?string $email): void
    {
        $ipKey = 'failed_login:ip:' . $ip;
        $emailKey = $email ? 'failed_login:email:' . $email : null;
        $ipThreshold = 5; // 5 failed attempts per IP
        $emailThreshold = 3; // 3 failed attempts per email

        $ipAttempts = RateLimiter::attempts($ipKey);
        $emailAttempts = $emailKey ? RateLimiter::attempts($emailKey) : 0;

        // Check IP-based brute force
        if ($ipAttempts >= $ipThreshold) {
            $this->reportBruteForceAttack($ip, $email, 'ip_based', $ipAttempts);
        }

        // Check email-based brute force
        if ($emailAttempts >= $emailThreshold && $email) {
            $this->reportBruteForceAttack($ip, $email, 'email_based', $emailAttempts);
        }
    }

    /**
     * Report brute force attack.
     */
    private function reportBruteForceAttack(string $ip, ?string $email, string $type, int $attempts): void
    {
        $cacheKey = "reported_brute_force:{$type}:{$ip}:" . ($email ?: 'no-email');

        // Only report once per hour to avoid spam
        if (Cache::has($cacheKey)) {
            return;
        }

        Cache::put($cacheKey, true, now()->addHour());

        $incidentType = $type === 'ip_based' ? 'brute_force' : 'failed_login';

        $incidentData = [
            'type' => $incidentType,
            'ip' => $ip,
            'email' => $email,
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
            'attempts' => $attempts,
            'timestamp' => now()->toISOString(),
            'details' => $type === 'ip_based'
                ? "Multiple failed login attempts from IP: {$attempts} attempts"
                : "Multiple failed login attempts for email: {$attempts} attempts",
        ];

        Log::warning('Brute force attack detected', $incidentData);

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
