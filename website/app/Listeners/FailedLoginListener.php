<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Notifications\SecurityIncident;
use App\Services\IpIntelligenceService;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;

class FailedLoginListener
{
    public function __construct(
        private readonly IpIntelligenceService $intel,
    ) {}

    public function handle(Failed $event): void
    {
        $ip    = request()->ip() ?? '0.0.0.0';
        $email = $event->credentials['email'] ?? null;

        $this->track($ip, $email);
        $this->checkBruteForce($ip, $email);
    }

    private function track(string $ip, ?string $email): void
    {
        $decay = 15 * 60; // 15 minutes in seconds

        RateLimiter::hit("failed_login:ip:{$ip}", $decay);

        if ($email) {
            RateLimiter::hit("failed_login:email:{$email}", $decay);
        }

        Log::info('Failed login attempt', [
            'ip'         => $ip,
            'email'      => $email,
            'user_agent' => request()->userAgent(),
            'url'        => request()->fullUrl(),
        ]);
    }

    private function checkBruteForce(string $ip, ?string $email): void
    {
        $ipAttempts    = RateLimiter::attempts("failed_login:ip:{$ip}");
        $emailAttempts = $email ? RateLimiter::attempts("failed_login:email:{$email}") : 0;

        if ($ipAttempts >= 5) {
            $this->report($ip, $email, 'ip_based', $ipAttempts);
        }

        if ($email && $emailAttempts >= 3) {
            $this->report($ip, $email, 'email_based', $emailAttempts);
        }
    }

    private function report(string $ip, ?string $email, string $type, int $attempts): void
    {
        // Dedup key: IP-based uses just IP; email-based scopes per victim email.
        // Previously the key included email for IP-based too, which let attackers
        // rotate emails to bypass the hourly dedup.
        $cacheKey = $type === 'ip_based'
            ? "reported_brute_force:ip:{$ip}"
            : "reported_brute_force:email:{$ip}:{$email}";

        if (Cache::has($cacheKey)) {
            return;
        }

        Cache::put($cacheKey, true, now()->addHour());

        // Accumulate all emails targeted from this IP over the past 2 hours
        $emailsKey       = "attack_emails:{$ip}";
        $targetedEmails  = Cache::get($emailsKey, []);

        if ($email && ! in_array($email, $targetedEmails, true)) {
            $targetedEmails[] = $email;
            Cache::put($emailsKey, $targetedEmails, now()->addHours(2));
        }

        $geo     = $this->intel->lookup($ip);
        $pattern = count($targetedEmails) > 1
            ? 'Credential stuffing (multiple accounts)'
            : 'Brute force / dictionary (single account)';

        $hostingCtx = $geo['is_proxy']   ? ' via VPN/Proxy'
            : ($geo['is_hosting'] ? ' via Datacenter/Bot' : '');

        $details = $type === 'ip_based'
            ? "{$attempts} attempts from {$geo['country']}{$hostingCtx} — {$pattern}"
            : "{$attempts} attempts on {$email} from {$geo['country']}{$hostingCtx}";

        $incidentData = [
            'type'             => $type === 'ip_based' ? 'brute_force' : 'failed_login',
            'ip'               => $ip,
            'email'            => $email,
            'user_agent'       => request()->userAgent(),
            'url'              => request()->fullUrl(),
            'method'           => request()->method(),
            'attempts'         => $attempts,
            'timestamp'        => now()->toISOString(),
            'details'          => $details,
            'geo'              => $geo,
            'pattern'          => $pattern,
            'targeted_emails'  => $targetedEmails,
            'threat_level'     => $this->intel->threatLevel($geo, $attempts),
        ];

        Log::warning('Brute force attack detected', $incidentData);
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
