<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Notifications\SecurityIncident;
use App\Services\IpIntelligenceService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class TestIncident extends Command
{
    protected $signature = 'incident:test {type=brute_force : brute_force, failed_login, or suspicious_activity} {--ip= : Specific IP to look up (defaults to a test IP)}';

    protected $description = 'Send a test security incident notification with full geo enrichment';

    public function handle(IpIntelligenceService $intel): int
    {
        $type = $this->argument('type');

        if (! in_array($type, ['brute_force', 'failed_login', 'suspicious_activity'], true)) {
            $this->error('Invalid incident type. Use: brute_force, failed_login, or suspicious_activity');

            return self::FAILURE;
        }

        // Use a real public IP so the geo lookup exercises the full path.
        // 8.8.8.8 is Google's DNS and always resolves cleanly.
        $ip = $this->option('ip') ?: '8.8.8.8';

        $this->info("Testing {$type} incident notification...");
        $this->line("  Looking up geo data for {$ip}...");

        $geo = $intel->lookup($ip);
        $this->line("  Location: {$geo['city']}, {$geo['country']} ({$geo['isp']})");

        $testData = $this->buildTestData($type, $ip, $geo, $intel);

        try {
            Notification::route('telegram', config('services.telegram.chat_id'))
                ->route('slack', config('services.slack.webhook_url'))
                ->route('mail', config('mail.security_email', config('mail.from.address')))
                ->notify(new SecurityIncident($testData));

            $this->info('✅ Test notification sent successfully!');
            $this->line('');
            $this->line('📧 Check your email');

            if (config('services.telegram.bot_token')) {
                $this->line('📱 Check your Telegram chat');
            }

            if (config('services.slack.webhook_url')) {
                $this->line('💬 Check your Slack channel');
            }

            $this->line('');
            $this->comment('Note: Notifications are queued. Run `php artisan queue:work` if not already running.');

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('❌ Failed to send test notification: ' . $e->getMessage());

            return self::FAILURE;
        }
    }

    private function buildTestData(string $type, string $ip, array $geo, IpIntelligenceService $intel): array
    {
        $base = [
            'ip'           => $ip,
            'user_agent'   => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/124.0 Safari/537.36',
            'url'          => 'https://andrej.nankov.mk/login',
            'method'       => 'POST',
            'timestamp'    => now()->toISOString(),
            'geo'          => $geo,
        ];

        return match ($type) {
            'brute_force' => array_merge($base, [
                'type'            => 'brute_force',
                'email'           => 'test@example.com',
                'attempts'        => 8,
                'pattern'         => 'Brute force / dictionary (single account)',
                'targeted_emails' => ['test@example.com'],
                'threat_level'    => $intel->threatLevel($geo, 8),
                'details'         => 'TEST: ' . (8 . ' attempts from ' . $geo['country'] . ' — Brute force / dictionary'),
            ]),
            'failed_login' => array_merge($base, [
                'type'            => 'failed_login',
                'email'           => 'admin@andrej.nankov.mk',
                'attempts'        => 5,
                'pattern'         => 'Credential stuffing (multiple accounts)',
                'targeted_emails' => ['admin@andrej.nankov.mk', 'info@andrej.nankov.mk', 'test@andrej.nankov.mk'],
                'threat_level'    => $intel->threatLevel($geo, 5),
                'details'         => 'TEST: 5 attempts on admin@andrej.nankov.mk from ' . $geo['country'],
            ]),
            'suspicious_activity' => array_merge($base, [
                'type'            => 'suspicious_activity',
                'email'           => null,
                'requests_per_min' => 75,
                'pattern'         => 'High-volume request flood',
                'threat_level'    => $intel->threatLevel($geo, 75),
                'details'         => 'TEST: Rate limit exceeded: 75 req/min from ' . $geo['country'],
            ]),
        };
    }
}
