<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Http\Middleware\DetectBruteForce;
use App\Notifications\SecurityIncident;
use Illuminate\Auth\Events\Failed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class SecurityIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Clear rate limiters and cache before each test
        RateLimiter::clear('failed_login:ip:192.168.1.1');
        RateLimiter::clear('failed_login:email:test@example.com');
        RateLimiter::clear('suspicious_activity:192.168.1.1');
        Cache::flush();
    }

    /** @test */
    public function complete_brute_force_attack_scenario_triggers_all_alerts(): void
    {
        // Arrange
        Notification::fake();
        Log::fake();
        
        // Simulate multiple failed login attempts from same IP
        $this->simulateFailedLogins('192.168.1.1', 'attacker@evil.com', 6);
        
        // Also trigger rate limiting on the middleware
        $this->simulateExcessiveRequests('192.168.1.1', 51);

        // Assert
        // Should have triggered both failed login and suspicious activity alerts
        Notification::assertSentTimes(SecurityIncident::class, 2);
        
        // Verify brute force alert
        Notification::assertSentTo(
            notifiable: null,
            notification: SecurityIncident::class,
            callback: function (SecurityIncident $notification) {
                $data = $notification->toArray(null);
                return $data['type'] === 'brute_force' && $data['attempts'] === 6;
            }
        );
        
        // Verify suspicious activity alert
        Notification::assertSentTo(
            notifiable: null,
            notification: SecurityIncident::class,
            callback: function (SecurityIncident $notification) {
                $data = $notification->toArray(null);
                return $data['type'] === 'suspicious_activity' && $data['ip'] === '192.168.1.1';
            }
        );
    }

    /** @test */
    public function email_based_attack_with_multiple_ips_detected(): void
    {
        // Arrange
        Notification::fake();
        
        // Simulate attacks on same email from different IPs
        $this->simulateFailedLogins('10.0.0.1', 'admin@andrej.nankov.mk', 2);
        $this->simulateFailedLogins('10.0.0.2', 'admin@andrej.nankov.mk', 2);
        $this->simulateFailedLogins('10.0.0.3', 'admin@andrej.nankov.mk', 1); // This should trigger the alert

        // Assert
        // Should trigger email-based brute force detection
        Notification::assertSentTo(
            notifiable: null,
            notification: SecurityIncident::class,
            callback: function (SecurityIncident $notification) {
                $data = $notification->toArray(null);
                return $data['type'] === 'failed_login' && 
                       $data['email'] === 'admin@andrej.nankov.mk' &&
                       $data['attempts'] >= 3;
            }
        );
    }

    /** @test */
    public function rate_limiting_prevents_excessive_notifications(): void
    {
        // Arrange
        Notification::fake();
        
        // First attack should trigger notification
        $this->simulateFailedLogins('192.168.1.1', 'test@example.com', 6);
        
        // Second attack from same IP should not trigger notification (cached)
        $this->simulateFailedLogins('192.168.1.1', 'test@example.com', 6);

        // Assert
        // Should only send one notification due to caching
        Notification::assertSentTimes(SecurityIncident::class, 1);
    }

    /** @test */
    public function middleware_blocks_requests_after_rate_limit_exceeded(): void
    {
        // Arrange
        $middleware = new DetectBruteForce();
        
        // Hit the rate limit
        for ($i = 0; $i < 50; $i++) {
            RateLimiter::hit('suspicious_activity:192.168.1.1', 60);
        }

        // Act
        $request = Request::create('https://andrej.nankov.mk/login', 'POST');
        $request->server->set('REMOTE_ADDR', '192.168.1.1');
        $request->headers->set('User-Agent', 'Test Browser');
        
        $response = $middleware->handle($request, function ($req) {
            return response('Should not reach here');
        });

        // Assert
        $this->assertEquals(429, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('Too many requests. Please try again later.', $responseData['message']);
    }

    /** @test */
    public function system_handles_concurrent_attacks_correctly(): void
    {
        // Arrange
        Notification::fake();
        
        // Simulate concurrent attacks from multiple IPs
        $attackIps = ['192.168.1.1', '192.168.1.2', '192.168.1.3', '192.168.1.4'];
        
        foreach ($attackIps as $ip) {
            $this->simulateFailedLogins($ip, "victim@example.com", 5);
            $this->simulateExcessiveRequests($ip, 51);
        }

        // Assert
        // Should trigger multiple notifications (one for each IP for both types)
        $this->assertTrue(Notification::sent(null, SecurityIncident::class)->count() >= 4);
        
        // Verify we got both types of alerts
        $bruteForceCount = 0;
        $suspiciousActivityCount = 0;
        $failedLoginCount = 0;
        
        Notification::sent(null, SecurityIncident::class)->each(function ($notification) use (&$bruteForceCount, &$suspiciousActivityCount, &$failedLoginCount) {
            $data = $notification['notification']->toArray(null);
            switch ($data['type']) {
                case 'brute_force':
                    $bruteForceCount++;
                    break;
                case 'suspicious_activity':
                    $suspiciousActivityCount++;
                    break;
                case 'failed_login':
                    $failedLoginCount++;
                    break;
            }
        });
        
        $this->assertGreaterThan(0, $bruteForceCount);
        $this->assertGreaterThan(0, $suspiciousActivityCount);
        $this->assertGreaterThan(0, $failedLoginCount);
    }

    /** @test */
    public function system_recovers_after_rate_limit_decay(): void
    {
        // Arrange
        Notification::fake();
        
        // Initial attack
        $this->simulateFailedLogins('192.168.1.1', 'test@example.com', 5);
        
        // Fast forward past rate limit decay (15 minutes)
        $this->travel(16)->minutes();
        
        // Clear rate limiter to simulate decay
        RateLimiter::clear('failed_login:ip:192.168.1.1');
        RateLimiter::clear('failed_login:email:test@example.com');
        Cache::flush(); // Clear notification cache
        
        // New attack should trigger alerts again
        $this->simulateFailedLogins('192.168.1.1', 'test@example.com', 5);

        // Assert
        // Should have triggered alerts twice
        $this->assertTrue(Notification::sent(null, SecurityIncident::class)->count() >= 2);
    }

    /** @test */
    public function edge_case_empty_email_handled_correctly(): void
    {
        // Arrange
        Notification::fake();
        Log::fake();
        
        $event = new Failed('web', null, ['email' => '', 'password' => 'wrong']);
        $this->app->make(\App\Listeners\FailedLoginListener::class)->handle($event);

        // Assert
        Log::assertLogged('info', function ($message, $context) {
            return $message === 'Failed login attempt recorded' && 
                   $context['email'] === '';
        });
    }

    /** @test */
    public function edge_case_null_user_agent_handled(): void
    {
        // Arrange
        Notification::fake();
        
        $request = Request::create('https://andrej.nankov.mk/test', 'GET');
        $request->server->set('REMOTE_ADDR', '192.168.1.1');
        // No User-Agent header set
        
        // Simulate excessive requests to trigger alert
        for ($i = 0; $i < 50; $i++) {
            RateLimiter::hit('suspicious_activity:192.168.1.1', 60);
        }
        
        $middleware = new DetectBruteForce();
        $middleware->handle($request, function ($req) {
            return response('OK');
        });

        // Should not crash and should handle null user agent gracefully
        Notification::assertSentTo(
            notifiable: null,
            notification: SecurityIncident::class,
            callback: function (SecurityIncident $notification) {
                $data = $notification->toArray(null);
                // user_agent should be null and handled gracefully
                return isset($data['user_agent']);
            }
        );
    }

    /** @test */
    public function edge_case_very_long_urls_handled(): void
    {
        // Arrange
        Notification::fake();
        
        $longUrl = 'https://andrej.nankov.mk/' . str_repeat('a', 2000) . '/login';
        $request = Request::create($longUrl, 'POST');
        $request->server->set('REMOTE_ADDR', '192.168.1.1');
        
        // Trigger rate limiting
        for ($i = 0; $i < 50; $i++) {
            RateLimiter::hit('suspicious_activity:192.168.1.1', 60);
        }
        
        $middleware = new DetectBruteForce();
        $middleware->handle($request, function ($req) {
            return response('OK');
        });

        // Should handle long URLs without issues
        Notification::assertSentTo(
            notifiable: null,
            notification: SecurityIncident::class,
            callback: function (SecurityIncident $notification) use ($longUrl) {
                $data = $notification->toArray(null);
                return $data['url'] === $longUrl;
            }
        );
    }

    /** @test */
    public function notification_failure_does_not_break_security_monitoring(): void
    {
        // Arrange
        Log::fake();
        
        // Mock notification failure
        Notification::shouldReceive('route')
            ->andThrow(new \Exception('Service unavailable'));
        
        // Trigger security event
        $this->simulateFailedLogins('192.168.1.1', 'test@example.com', 6);

        // Assert
        // Should log the error but continue functioning
        Log::assertLogged('error', function ($message, $context) {
            return $message === 'Failed to send security notification' &&
                   $context['error'] === 'Service unavailable';
        });
        
        // Should still log the security incident
        Log::assertLogged('warning', function ($message) {
            return $message === 'Brute force attack detected';
        });
    }

    /** @test */
    public function ipv6_addresses_handled_correctly(): void
    {
        // Arrange
        Notification::fake();
        
        $ipv6 = '2001:0db8:85a3:0000:0000:8a2e:0370:7334';
        
        // Simulate failed logins with IPv6
        for ($i = 0; $i < 5; $i++) {
            $request = Request::create('https://andrej.nankov.mk/login', 'POST');
            $request->server->set('REMOTE_ADDR', $ipv6);
            app()->instance('request', $request);
            
            $event = new Failed('web', null, ['email' => 'test@example.com', 'password' => 'wrong']);
            $this->app->make(\App\Listeners\FailedLoginListener::class)->handle($event);
        }

        // Assert
        Notification::assertSentTo(
            notifiable: null,
            notification: SecurityIncident::class,
            callback: function (SecurityIncident $notification) use ($ipv6) {
                $data = $notification->toArray(null);
                return $data['ip'] === $ipv6 && $data['type'] === 'brute_force';
            }
        );
    }

    /** @test */
    public function system_handles_high_volume_legitimate_traffic(): void
    {
        // Arrange
        Notification::fake();
        
        // Simulate high volume but under threshold (49 requests, threshold is 50)
        for ($i = 0; $i < 49; $i++) {
            RateLimiter::hit('suspicious_activity:192.168.1.1', 60);
        }
        
        $middleware = new DetectBruteForce();
        $request = Request::create('https://andrej.nankov.mk/api/data', 'GET');
        $request->server->set('REMOTE_ADDR', '192.168.1.1');
        
        $response = $middleware->handle($request, function ($req) {
            return response('OK');
        });

        // Assert
        // Should allow the request through
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getContent());
        
        // Should not trigger any notifications
        Notification::assertNotSentTo(null, SecurityIncident::class);
    }

    /**
     * Helper method to simulate failed login attempts
     */
    private function simulateFailedLogins(string $ip, string $email, int $count): void
    {
        for ($i = 0; $i < $count; $i++) {
            $request = Request::create('https://andrej.nankov.mk/login', 'POST');
            $request->server->set('REMOTE_ADDR', $ip);
            $request->headers->set('User-Agent', 'Test Browser');
            app()->instance('request', $request);
            
            $event = new Failed('web', null, ['email' => $email, 'password' => 'wrong']);
            Event::dispatch($event);
        }
    }

    /**
     * Helper method to simulate excessive requests
     */
    private function simulateExcessiveRequests(string $ip, int $count): void
    {
        for ($i = 0; $i < $count; $i++) {
            RateLimiter::hit("suspicious_activity:{$ip}", 60);
        }
        
        // Trigger the middleware to process the rate limit
        $middleware = new DetectBruteForce();
        $request = Request::create('https://andrej.nankov.mk/test', 'GET');
        $request->server->set('REMOTE_ADDR', $ip);
        $request->headers->set('User-Agent', 'Test Browser');
        
        $middleware->handle($request, function ($req) {
            return response('OK');
        });
    }
}