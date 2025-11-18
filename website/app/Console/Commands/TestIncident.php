<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Notifications\SecurityIncident;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class TestIncident extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'incident:test {type=brute_force : The type of incident to test (brute_force, failed_login, suspicious_activity)}';

    /**
     * The console command description.
     */
    protected $description = 'Test security incident notifications (Telegram, Slack, Email)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $type = $this->argument('type');

        if (!in_array($type, ['brute_force', 'failed_login', 'suspicious_activity'])) {
            $this->error('Invalid incident type. Use: brute_force, failed_login, or suspicious_activity');
            return self::FAILURE;
        }

        $this->info("Testing {$type} incident notification...");

        $testData = $this->generateTestData($type);

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
            $this->comment('Note: Notifications are queued. Run `php artisan queue:work` if using queues.');

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('❌ Failed to send test notification: ' . $e->getMessage());
            return self::FAILURE;
        }
    }

    /**
     * Generate test data for different incident types.
     */
    private function generateTestData(string $type): array
    {
        $baseData = [
            'ip' => '192.168.1.100',
            'user_agent' => 'Mozilla/5.0 (Test Browser) Security Test',
            'url' => 'https://andrej.nankov.mk/login',
            'timestamp' => now()->toISOString(),
        ];

        return match ($type) {
            'brute_force' => array_merge($baseData, [
                'type' => 'brute_force',
                'email' => 'test@example.com',
                'attempts' => 8,
                'details' => 'TEST: Multiple failed login attempts detected from IP address',
            ]),
            'failed_login' => array_merge($baseData, [
                'type' => 'failed_login',
                'email' => 'admin@andrej.nankov.mk',
                'attempts' => 5,
                'details' => 'TEST: Repeated failed login attempts for specific email address',
            ]),
            'suspicious_activity' => array_merge($baseData, [
                'type' => 'suspicious_activity',
                'email' => null,
                'details' => 'TEST: Too many requests from single IP address (rate limiting triggered)',
            ]),
        };
    }
}
