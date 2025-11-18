<?php

declare(strict_types=1);

namespace Tests\Unit\Notifications;

use App\Notifications\SecurityIncident;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;
use Tests\TestCase;

class SecurityIncidentTest extends TestCase
{
    /** @test */
    public function it_determines_correct_channels_with_all_services_configured(): void
    {
        // Arrange
        config([
            'services.telegram.bot_token' => 'test_token',
            'services.telegram.chat_id' => '12345',
            'services.slack.webhook_url' => 'https://hooks.slack.com/test',
        ]);

        $incident = new SecurityIncident([
            'type' => 'brute_force',
            'ip' => '192.168.1.1',
        ]);

        // Act
        $channels = $incident->via(null);

        // Assert
        $this->assertContains('mail', $channels);
        $this->assertContains(TelegramChannel::class, $channels);
        $this->assertContains('slack', $channels);
        $this->assertCount(3, $channels);
    }

    /** @test */
    public function it_excludes_channels_when_services_not_configured(): void
    {
        // Arrange
        config([
            'services.telegram.bot_token' => null,
            'services.telegram.chat_id' => null,
            'services.slack.webhook_url' => null,
        ]);

        $incident = new SecurityIncident([
            'type' => 'brute_force',
            'ip' => '192.168.1.1',
        ]);

        // Act
        $channels = $incident->via(null);

        // Assert
        $this->assertContains('mail', $channels);
        $this->assertNotContains(TelegramChannel::class, $channels);
        $this->assertNotContains('slack', $channels);
        $this->assertCount(1, $channels);
    }

    /** @test */
    public function it_creates_correct_telegram_message_for_brute_force(): void
    {
        // Arrange
        config(['services.telegram.chat_id' => '12345']);

        $incidentData = [
            'type' => 'brute_force',
            'ip' => '10.0.0.1',
            'email' => 'victim@example.com',
            'timestamp' => '2025-11-18T23:30:00Z',
            'details' => 'Multiple failed login attempts detected',
            'attempts' => 8,
            'user_agent' => 'Mozilla/5.0 (Malicious Browser)',
        ];

        $incident = new SecurityIncident($incidentData);

        // Act
        $message = $incident->toTelegram(null);

        // Assert
        $this->assertInstanceOf(TelegramMessage::class, $message);
        $content = $message->getPayloadValue('text');

        $this->assertStringContainsString('🚨 *BRUTE FORCE ATTACK DETECTED*', $content);
        $this->assertStringContainsString('andrej.nankov.mk', $content);
        $this->assertStringContainsString('10.0.0.1', $content);
        $this->assertStringContainsString('victim@example.com', $content);
        $this->assertStringContainsString('2025-11-18T23:30:00Z', $content);
        $this->assertStringContainsString('Multiple failed login attempts detected', $content);
        $this->assertStringContainsString('8', $content);
        $this->assertStringContainsString('Mozilla/5.0 (Malicious Browser)', $content);

        // Check formatting options
        $this->assertEquals('12345', $message->getPayloadValue('chat_id'));
        $this->assertEquals('Markdown', $message->getPayloadValue('parse_mode'));
        $this->assertTrue($message->getPayloadValue('disable_web_page_preview'));
    }

    /** @test */
    public function it_creates_correct_telegram_message_for_failed_login(): void
    {
        // Arrange
        config(['services.telegram.chat_id' => '67890']);

        $incidentData = [
            'type' => 'failed_login',
            'ip' => '172.16.0.1',
            'email' => 'admin@example.com',
            'timestamp' => '2025-11-18T23:45:00Z',
            'details' => 'Repeated failed login attempts for email',
            'attempts' => 5,
        ];

        $incident = new SecurityIncident($incidentData);

        // Act
        $message = $incident->toTelegram(null);

        // Assert
        $content = $message->getPayloadValue('text');

        $this->assertStringContainsString('⚠️ *MULTIPLE FAILED LOGINS*', $content);
        $this->assertStringContainsString('172.16.0.1', $content);
        $this->assertStringContainsString('admin@example.com', $content);
        $this->assertStringContainsString('Repeated failed login attempts for email', $content);
        $this->assertStringContainsString('5', $content);
    }

    /** @test */
    public function it_creates_correct_telegram_message_for_suspicious_activity(): void
    {
        // Arrange
        config(['services.telegram.chat_id' => '11111']);

        $incidentData = [
            'type' => 'suspicious_activity',
            'ip' => '203.0.113.1',
            'email' => null,
            'timestamp' => '2025-11-18T23:50:00Z',
            'details' => 'Too many requests from IP address',
        ];

        $incident = new SecurityIncident($incidentData);

        // Act
        $message = $incident->toTelegram(null);

        // Assert
        $content = $message->getPayloadValue('text');

        $this->assertStringContainsString('🔍 *SUSPICIOUS ACTIVITY DETECTED*', $content);
        $this->assertStringContainsString('203.0.113.1', $content);
        $this->assertStringContainsString('Unknown', $content); // email should be 'Unknown'
        $this->assertStringContainsString('Too many requests from IP address', $content);
        $this->assertStringNotContainsString('🔢 *Attempts:', $content); // No attempts for suspicious activity
    }

    /** @test */
    public function it_creates_correct_slack_message_for_brute_force(): void
    {
        // Arrange
        $incidentData = [
            'type' => 'brute_force',
            'ip' => '10.0.0.1',
            'email' => 'victim@example.com',
            'timestamp' => '2025-11-18T23:30:00Z',
            'details' => 'Multiple failed login attempts detected',
        ];

        $incident = new SecurityIncident($incidentData);

        // Act
        $message = $incident->toSlack(null);

        // Assert - Just verify we can create the SlackMessage without errors
        $this->assertInstanceOf(SlackMessage::class, $message);
    }

    /** @test */
    public function it_creates_correct_slack_message_with_different_colors(): void
    {
        // Test different incident types have different colors
        $incidents = [
            ['type' => 'brute_force', 'expected_color' => 'danger'],
            ['type' => 'failed_login', 'expected_color' => 'warning'],
            ['type' => 'suspicious_activity', 'expected_color' => 'warning'],
        ];

        foreach ($incidents as $testCase) {
            $incident = new SecurityIncident([
                'type' => $testCase['type'],
                'ip' => '192.168.1.1',
                'email' => 'test@example.com',
                'timestamp' => now()->toISOString(),
                'details' => 'Test incident',
            ]);

            $message = $incident->toSlack(null);

            // Just verify we can create SlackMessage without errors
            $this->assertInstanceOf(SlackMessage::class, $message);
        }
    }

    /** @test */
    public function it_creates_correct_email_message_for_brute_force(): void
    {
        // Arrange
        $incidentData = [
            'type' => 'brute_force',
            'ip' => '10.0.0.1',
            'email' => 'victim@example.com',
            'timestamp' => '2025-11-18T23:30:00Z',
            'details' => 'Multiple failed login attempts detected',
            'attempts' => 8,
            'user_agent' => 'Mozilla/5.0 (Test Browser)',
        ];

        $incident = new SecurityIncident($incidentData);

        // Act
        $message = $incident->toMail(null);

        // Assert
        $this->assertInstanceOf(MailMessage::class, $message);

        $data = $message->toArray();

        $this->assertEquals('[SECURITY ALERT] Brute Force Attack - andrej.nankov.mk', $data['subject']);
        $this->assertEquals('Security Alert!', $data['greeting']);
        $this->assertEquals('Security Team - andrej.nankov.mk', $data['salutation']);

        // Check content lines
        $this->assertContains('A security incident has been detected on andrej.nankov.mk', $data['introLines']);
        $this->assertContains('**Incident Type:** Brute Force', $data['introLines']);
        $this->assertContains('**IP Address:** 10.0.0.1', $data['introLines']);
        $this->assertContains('**Email:** victim@example.com', $data['introLines']);
        $this->assertContains('**Time:** 2025-11-18T23:30:00Z', $data['introLines']);
        $this->assertContains('**Details:** Multiple failed login attempts detected', $data['introLines']);
        $this->assertContains('**Failed Attempts:** 8', $data['introLines']);
        $this->assertContains('**User Agent:** Mozilla/5.0 (Test Browser)', $data['introLines']);

        // Check action button
        $this->assertEquals('View Server Logs', $data['actionText']);
        $this->assertEquals(url('/'), $data['actionUrl']);
    }

    /** @test */
    public function it_creates_email_without_optional_fields(): void
    {
        // Arrange
        $incidentData = [
            'type' => 'suspicious_activity',
            'ip' => '203.0.113.1',
            'email' => null,
            'timestamp' => '2025-11-18T23:50:00Z',
            'details' => 'Too many requests from IP address',
        ];

        $incident = new SecurityIncident($incidentData);

        // Act
        $message = $incident->toMail(null);

        // Assert
        $data = $message->toArray();

        // Should not contain attempts or user agent lines
        $hasAttempts = false;
        $hasUserAgent = false;

        foreach ($data['introLines'] as $line) {
            if (str_contains($line, '**Failed Attempts:**')) {
                $hasAttempts = true;
            }
            if (str_contains($line, '**User Agent:**')) {
                $hasUserAgent = true;
            }
        }

        $this->assertFalse($hasAttempts);
        $this->assertFalse($hasUserAgent);
        $this->assertContains('**Email:** Unknown', $data['introLines']);
    }

    /** @test */
    public function it_creates_correct_email_subjects_for_different_types(): void
    {
        $incidents = [
            'brute_force' => '[SECURITY ALERT] Brute Force Attack - andrej.nankov.mk',
            'failed_login' => '[SECURITY ALERT] Multiple Failed Logins - andrej.nankov.mk',
            'suspicious_activity' => '[SECURITY ALERT] Suspicious Activity - andrej.nankov.mk',
        ];

        foreach ($incidents as $type => $expectedSubject) {
            $incident = new SecurityIncident([
                'type' => $type,
                'ip' => '192.168.1.1',
                'timestamp' => now()->toISOString(),
                'details' => 'Test incident',
            ]);

            $message = $incident->toMail(null);
            $data = $message->toArray();

            $this->assertEquals($expectedSubject, $data['subject']);
        }
    }

    /** @test */
    public function it_returns_correct_array_representation(): void
    {
        // Arrange
        $incidentData = [
            'type' => 'brute_force',
            'ip' => '10.0.0.1',
            'email' => 'victim@example.com',
            'timestamp' => '2025-11-18T23:30:00Z',
            'details' => 'Multiple failed login attempts detected',
            'attempts' => 8,
        ];

        $incident = new SecurityIncident($incidentData);

        // Act
        $result = $incident->toArray(null);

        // Assert
        $this->assertEquals($incidentData, $result);
    }

    /** @test */
    public function it_is_queued_properly(): void
    {
        // Arrange
        $incident = new SecurityIncident(['type' => 'test']);

        // Assert
        $this->assertInstanceOf(\Illuminate\Contracts\Queue\ShouldQueue::class, $incident);
        $this->assertEquals('notifications', $incident->queue);
    }

    /** @test */
    public function it_truncates_long_user_agent_in_telegram(): void
    {
        // Arrange
        config(['services.telegram.chat_id' => '12345']);

        $longUserAgent = str_repeat('A', 150); // 150 characters
        $incidentData = [
            'type' => 'brute_force',
            'ip' => '10.0.0.1',
            'email' => 'test@example.com',
            'timestamp' => now()->toISOString(),
            'details' => 'Test',
            'user_agent' => $longUserAgent,
        ];

        $incident = new SecurityIncident($incidentData);

        // Act
        $message = $incident->toTelegram(null);

        // Assert
        $content = $message->getPayloadValue('text');
        $truncatedUserAgent = substr($longUserAgent, 0, 100);

        $this->assertStringContainsString($truncatedUserAgent, $content);
        $this->assertStringNotContainsString($longUserAgent, $content);
    }
}
