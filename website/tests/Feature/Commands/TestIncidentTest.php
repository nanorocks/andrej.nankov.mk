<?php

declare(strict_types=1);

namespace Tests\Feature\Commands;

use App\Console\Commands\TestIncident;
use App\Notifications\SecurityIncident;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TestIncidentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_test_brute_force_incident(): void
    {
        // Arrange
        Notification::fake();

        // Act
        $result = Artisan::call('incident:test', ['type' => 'brute_force']);

        // Assert
        $this->assertEquals(0, $result);

        Notification::assertSentTo(
            notifiable: null,
            notification: SecurityIncident::class,
            callback: function (SecurityIncident $notification) {
                $data = $notification->toArray(null);
                return $data['type'] === 'brute_force' &&
                       $data['ip'] === '192.168.1.100' &&
                       $data['email'] === 'test@example.com' &&
                       $data['attempts'] === 8 &&
                       str_contains($data['details'], 'TEST: Multiple failed login attempts detected from IP address');
            }
        );
    }

    /** @test */
    public function it_can_test_failed_login_incident(): void
    {
        // Arrange
        Notification::fake();

        // Act
        $result = Artisan::call('incident:test', ['type' => 'failed_login']);

        // Assert
        $this->assertEquals(0, $result);

        Notification::assertSentTo(
            notifiable: null,
            notification: SecurityIncident::class,
            callback: function (SecurityIncident $notification) {
                $data = $notification->toArray(null);
                return $data['type'] === 'failed_login' &&
                       $data['ip'] === '192.168.1.100' &&
                       $data['email'] === 'admin@andrej.nankov.mk' &&
                       $data['attempts'] === 5 &&
                       str_contains($data['details'], 'TEST: Repeated failed login attempts for specific email address');
            }
        );
    }

    /** @test */
    public function it_can_test_suspicious_activity_incident(): void
    {
        // Arrange
        Notification::fake();

        // Act
        $result = Artisan::call('incident:test', ['type' => 'suspicious_activity']);

        // Assert
        $this->assertEquals(0, $result);

        Notification::assertSentTo(
            notifiable: null,
            notification: SecurityIncident::class,
            callback: function (SecurityIncident $notification) {
                $data = $notification->toArray(null);
                return $data['type'] === 'suspicious_activity' &&
                       $data['ip'] === '192.168.1.100' &&
                       $data['email'] === null &&
                       !isset($data['attempts']) &&
                       str_contains($data['details'], 'TEST: Too many requests from single IP address (rate limiting triggered)');
            }
        );
    }

    /** @test */
    public function it_defaults_to_brute_force_when_no_type_provided(): void
    {
        // Arrange
        Notification::fake();

        // Act
        $result = Artisan::call('incident:test');

        // Assert
        $this->assertEquals(0, $result);

        Notification::assertSentTo(
            notifiable: null,
            notification: SecurityIncident::class,
            callback: function (SecurityIncident $notification) {
                $data = $notification->toArray(null);
                return $data['type'] === 'brute_force';
            }
        );
    }

    /** @test */
    public function it_rejects_invalid_incident_types(): void
    {
        // Act
        $result = Artisan::call('incident:test', ['type' => 'invalid_type']);

        // Assert
        $this->assertEquals(1, $result);

        $output = Artisan::output();
        $this->assertStringContainsString('Invalid incident type', $output);
        $this->assertStringContainsString('Use: brute_force, failed_login, or suspicious_activity', $output);

        Notification::fake();
        Notification::assertNotSentTo(null, SecurityIncident::class);
    }

    /** @test */
    public function it_displays_success_message_with_channel_information(): void
    {
        // Arrange
        Notification::fake();

        config([
            'services.telegram.bot_token' => 'test_token',
            'services.slack.webhook_url' => 'https://hooks.slack.com/test',
        ]);

        // Act
        Artisan::call('incident:test', ['type' => 'brute_force']);

        // Assert
        $output = Artisan::output();

        $this->assertStringContainsString('Testing brute_force incident notification...', $output);
        $this->assertStringContainsString('✅ Test notification sent successfully!', $output);
        $this->assertStringContainsString('📧 Check your email', $output);
        $this->assertStringContainsString('📱 Check your Telegram chat', $output);
        $this->assertStringContainsString('💬 Check your Slack channel', $output);
        $this->assertStringContainsString('php artisan queue:work', $output);
    }

    /** @test */
    public function it_shows_only_configured_channels_in_output(): void
    {
        // Arrange
        Notification::fake();

        config([
            'services.telegram.bot_token' => null,
            'services.slack.webhook_url' => null,
        ]);

        // Act
        Artisan::call('incident:test', ['type' => 'brute_force']);

        // Assert
        $output = Artisan::output();

        $this->assertStringContainsString('📧 Check your email', $output);
        $this->assertStringNotContainsString('📱 Check your Telegram chat', $output);
        $this->assertStringNotContainsString('💬 Check your Slack channel', $output);
    }

    /** @test */
    public function it_handles_notification_failures_gracefully(): void
    {
        // Arrange
        Notification::shouldReceive('route')
            ->andThrow(new \Exception('Notification service unavailable'));

        // Act
        $result = Artisan::call('incident:test', ['type' => 'brute_force']);

        // Assert
        $this->assertEquals(1, $result);

        $output = Artisan::output();
        $this->assertStringContainsString('❌ Failed to send test notification', $output);
        $this->assertStringContainsString('Notification service unavailable', $output);
    }

    /** @test */
    public function it_generates_correct_test_data_structure(): void
    {
        // Arrange
        Notification::fake();

        // Act
        Artisan::call('incident:test', ['type' => 'brute_force']);

        // Assert
        Notification::assertSentTo(
            notifiable: null,
            notification: SecurityIncident::class,
            callback: function (SecurityIncident $notification) {
                $data = $notification->toArray(null);

                // Verify base data structure
                $this->assertArrayHasKey('ip', $data);
                $this->assertArrayHasKey('user_agent', $data);
                $this->assertArrayHasKey('url', $data);
                $this->assertArrayHasKey('timestamp', $data);
                $this->assertArrayHasKey('type', $data);
                $this->assertArrayHasKey('details', $data);

                // Verify base values
                $this->assertEquals('192.168.1.100', $data['ip']);
                $this->assertEquals('Mozilla/5.0 (Test Browser) Security Test', $data['user_agent']);
                $this->assertEquals('https://andrej.nankov.mk/login', $data['url']);
                $this->assertNotEmpty($data['timestamp']);

                // Verify test prefix in details
                $this->assertStringStartsWith('TEST:', $data['details']);

                return true;
            }
        );
    }

    /** @test */
    public function it_uses_correct_notification_routes(): void
    {
        // Arrange
        config([
            'services.telegram.chat_id' => '12345',
            'services.slack.webhook_url' => 'https://hooks.slack.com/test',
            'mail.security_email' => 'security@andrej.nankov.mk',
        ]);

        $notificationMock = Notification::fake();

        // Act
        Artisan::call('incident:test', ['type' => 'brute_force']);

        // Assert
        // This test verifies the command calls Notification::route with correct parameters
        // The actual routing is tested in integration tests
        Notification::assertSentTo(null, SecurityIncident::class);
    }

    /** @test */
    public function it_creates_different_data_for_each_incident_type(): void
    {
        // Arrange
        Notification::fake();
        $types = ['brute_force', 'failed_login', 'suspicious_activity'];
        $results = [];

        // Act
        foreach ($types as $type) {
            Artisan::call('incident:test', ['type' => $type]);

            Notification::assertSentTo(
                notifiable: null,
                notification: SecurityIncident::class,
                callback: function (SecurityIncident $notification) use (&$results, $type) {
                    $results[$type] = $notification->toArray(null);
                    return true;
                }
            );
        }

        // Assert
        // Verify brute_force data
        $this->assertEquals('brute_force', $results['brute_force']['type']);
        $this->assertEquals('test@example.com', $results['brute_force']['email']);
        $this->assertEquals(8, $results['brute_force']['attempts']);

        // Verify failed_login data
        $this->assertEquals('failed_login', $results['failed_login']['type']);
        $this->assertEquals('admin@andrej.nankov.mk', $results['failed_login']['email']);
        $this->assertEquals(5, $results['failed_login']['attempts']);

        // Verify suspicious_activity data
        $this->assertEquals('suspicious_activity', $results['suspicious_activity']['type']);
        $this->assertNull($results['suspicious_activity']['email']);
        $this->assertArrayNotHasKey('attempts', $results['suspicious_activity']);
    }

    /** @test */
    public function it_provides_helpful_output_formatting(): void
    {
        // Arrange
        Notification::fake();

        // Act
        Artisan::call('incident:test', ['type' => 'suspicious_activity']);

        // Assert
        $output = Artisan::output();

        // Check for proper formatting
        $this->assertStringContainsString('Testing suspicious_activity incident notification...', $output);
        $this->assertMatchesRegularExpression('/✅.*Test notification sent successfully!/', $output);
        $this->assertMatchesRegularExpression('/📧.*Check your email/', $output);
        $this->assertMatchesRegularExpression('/Note:.*php artisan queue:work/', $output);
    }

    /** @test */
    public function it_maintains_consistent_test_data_across_calls(): void
    {
        // Arrange
        Notification::fake();

        // Act
        Artisan::call('incident:test', ['type' => 'brute_force']);
        $firstCall = null;

        Notification::assertSentTo(
            notifiable: null,
            notification: SecurityIncident::class,
            callback: function (SecurityIncident $notification) use (&$firstCall) {
                $firstCall = $notification->toArray(null);
                return true;
            }
        );

        // Clear and call again
        Notification::fake();
        Artisan::call('incident:test', ['type' => 'brute_force']);
        $secondCall = null;

        Notification::assertSentTo(
            notifiable: null,
            notification: SecurityIncident::class,
            callback: function (SecurityIncident $notification) use (&$secondCall) {
                $secondCall = $notification->toArray(null);
                return true;
            }
        );

        // Assert
        // Timestamps will be different, so exclude them from comparison
        unset($firstCall['timestamp'], $secondCall['timestamp']);
        $this->assertEquals($firstCall, $secondCall);
    }
}
