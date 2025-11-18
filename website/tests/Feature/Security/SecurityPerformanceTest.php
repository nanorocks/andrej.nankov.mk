<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Http\Middleware\DetectBruteForce;
use App\Listeners\FailedLoginListener;
use App\Notifications\SecurityIncident;
use Illuminate\Auth\Events\Failed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class SecurityPerformanceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Use array cache for faster testing
        config(['cache.default' => 'array']);
    }

    /** @test */
    public function middleware_performs_efficiently_under_load(): void
    {
        // Arrange
        $middleware = new DetectBruteForce();
        $iterations = 1000;

        // Act
        $startTime = microtime(true);

        for ($i = 0; $i < $iterations; $i++) {
            $request = Request::create("https://andrej.nankov.mk/test/{$i}", 'GET');
            $request->server->set('REMOTE_ADDR', '192.168.1.' . ($i % 254 + 1));

            $response = $middleware->handle($request, function ($req) {
                return response('OK');
            });

            $this->assertEquals(200, $response->getStatusCode());
        }

        $endTime = microtime(true);
        $duration = $endTime - $startTime;

        // Assert
        // Should complete 1000 requests in under 5 seconds
        $this->assertLessThan(5.0, $duration, "Middleware took {$duration} seconds for {$iterations} requests");

        // Average should be under 5ms per request
        $avgTime = ($duration / $iterations) * 1000;
        $this->assertLessThan(5.0, $avgTime, "Average request time: {$avgTime}ms");
    }

    /** @test */
    public function failed_login_listener_handles_burst_of_events(): void
    {
        // Arrange
        Notification::fake();
        Log::fake();

        $listener = new FailedLoginListener();
        $iterations = 500;

        // Act
        $startTime = microtime(true);

        for ($i = 0; $i < $iterations; $i++) {
            $request = Request::create('https://andrej.nankov.mk/login', 'POST');
            $request->server->set('REMOTE_ADDR', '192.168.1.' . ($i % 10 + 1));
            $request->headers->set('User-Agent', 'Test Browser');
            app()->instance('request', $request);

            $event = new Failed('web', null, [
                'email' => "user{$i}@example.com",
                'password' => 'wrong'
            ]);

            $listener->handle($event);
        }

        $endTime = microtime(true);
        $duration = $endTime - $startTime;

        // Assert
        $this->assertLessThan(3.0, $duration, "Listener took {$duration} seconds for {$iterations} events");

        // Verify some notifications were sent (but not spam due to caching)
        $this->assertTrue(Notification::sent(null, SecurityIncident::class)->count() > 0);
        $this->assertTrue(Notification::sent(null, SecurityIncident::class)->count() < $iterations / 2);
    }

    /** @test */
    public function rate_limiter_memory_usage_stays_reasonable(): void
    {
        // Arrange
        $initialMemory = memory_get_usage(true);

        // Act
        // Create many rate limiter keys
        for ($i = 0; $i < 1000; $i++) {
            RateLimiter::hit("test_key_{$i}", 60);
            RateLimiter::hit("another_key_{$i}", 3600);
        }

        $finalMemory = memory_get_usage(true);
        $memoryIncrease = $finalMemory - $initialMemory;

        // Assert
        // Memory increase should be reasonable (under 10MB for 2000 keys)
        $this->assertLessThan(10 * 1024 * 1024, $memoryIncrease,
            "Memory usage increased by " . ($memoryIncrease / 1024 / 1024) . " MB");
    }

    /** @test */
    public function cache_operations_are_efficient(): void
    {
        // Arrange
        $iterations = 1000;

        // Act
        $startTime = microtime(true);

        for ($i = 0; $i < $iterations; $i++) {
            $key = "test_cache_key_{$i}";

            // Check cache
            Cache::has($key);

            // Set cache if not exists
            if (!Cache::has($key)) {
                Cache::put($key, "value_{$i}", now()->addMinutes(60));
            }

            // Get from cache
            Cache::get($key);
        }

        $endTime = microtime(true);
        $duration = $endTime - $startTime;

        // Assert
        $this->assertLessThan(2.0, $duration, "Cache operations took {$duration} seconds");

        $avgTime = ($duration / $iterations) * 1000;
        $this->assertLessThan(2.0, $avgTime, "Average cache operation time: {$avgTime}ms");
    }

    /** @test */
    public function notification_system_handles_queue_backlog(): void
    {
        // Arrange
        Notification::fake();

        // Simulate a burst of security incidents
        $incidents = [];
        for ($i = 0; $i < 100; $i++) {
            $incidents[] = new SecurityIncident([
                'type' => 'brute_force',
                'ip' => "192.168.1.{$i}",
                'email' => "user{$i}@example.com",
                'timestamp' => now()->toISOString(),
                'details' => 'Test incident',
                'attempts' => 5,
            ]);
        }

        // Act
        $startTime = microtime(true);

        foreach ($incidents as $incident) {
            Notification::route('mail', 'security@andrej.nankov.mk')
                ->notify($incident);
        }

        $endTime = microtime(true);
        $duration = $endTime - $startTime;

        // Assert
        $this->assertLessThan(5.0, $duration, "Notification queuing took {$duration} seconds");

        // All notifications should be queued
        $this->assertEquals(100, Notification::sent(null, SecurityIncident::class)->count());
    }

    /** @test */
    public function system_handles_concurrent_different_attack_types(): void
    {
        // Arrange
        Notification::fake();
        $middleware = new DetectBruteForce();
        $listener = new FailedLoginListener();

        // Act - Simulate concurrent attacks
        $startTime = microtime(true);

        // Type 1: Rate limiting attacks
        for ($i = 0; $i < 60; $i++) {
            RateLimiter::hit('suspicious_activity:10.0.0.1', 60);
        }

        // Type 2: Failed login attacks
        for ($i = 0; $i < 10; $i++) {
            $request = Request::create('https://andrej.nankov.mk/login', 'POST');
            $request->server->set('REMOTE_ADDR', '10.0.0.2');
            app()->instance('request', $request);

            $event = new Failed('web', null, ['email' => 'target@example.com', 'password' => 'wrong']);
            $listener->handle($event);
        }

        // Type 3: Middleware rate limiting
        $request = Request::create('https://andrej.nankov.mk/api', 'GET');
        $request->server->set('REMOTE_ADDR', '10.0.0.1');
        $response = $middleware->handle($request, function ($req) {
            return response('OK');
        });

        $endTime = microtime(true);
        $duration = $endTime - $startTime;

        // Assert
        $this->assertLessThan(2.0, $duration, "Concurrent attack simulation took {$duration} seconds");
        $this->assertEquals(429, $response->getStatusCode());

        // Should detect multiple incident types
        $this->assertGreaterThan(0, Notification::sent(null, SecurityIncident::class)->count());
    }

    /** @test */
    public function large_incident_data_processed_efficiently(): void
    {
        // Arrange
        Notification::fake();

        // Create incident with large data
        $largeUserAgent = str_repeat('Mozilla/5.0 (Large User Agent) ', 100); // ~2.7KB
        $largeUrl = 'https://andrej.nankov.mk/' . str_repeat('path/', 100); // ~500B

        $incidentData = [
            'type' => 'brute_force',
            'ip' => '192.168.1.1',
            'email' => 'test@example.com',
            'user_agent' => $largeUserAgent,
            'url' => $largeUrl,
            'timestamp' => now()->toISOString(),
            'details' => str_repeat('Large incident details. ', 50), // ~1KB
            'attempts' => 10,
        ];

        // Act
        $startTime = microtime(true);

        $incident = new SecurityIncident($incidentData);

        // Test all notification methods
        $telegramMessage = $incident->toTelegram(null);
        $slackMessage = $incident->toSlack(null);
        $mailMessage = $incident->toMail(null);
        $arrayData = $incident->toArray(null);

        $endTime = microtime(true);
        $duration = $endTime - $startTime;

        // Assert
        $this->assertLessThan(0.5, $duration, "Large incident processing took {$duration} seconds");

        // Verify data integrity
        $this->assertNotEmpty($telegramMessage);
        $this->assertNotEmpty($slackMessage);
        $this->assertNotEmpty($mailMessage);
        $this->assertEquals($incidentData, $arrayData);
    }

    /** @test */
    public function system_maintains_accuracy_under_stress(): void
    {
        // Arrange
        Notification::fake();
        RateLimiter::clear('failed_login:ip:192.168.1.1');

        $listener = new FailedLoginListener();
        $expectedThreshold = 5;

        // Act
        // Exactly hit the threshold
        for ($i = 0; $i < $expectedThreshold; $i++) {
            $request = Request::create('https://andrej.nankov.mk/login', 'POST');
            $request->server->set('REMOTE_ADDR', '192.168.1.1');
            app()->instance('request', $request);

            $event = new Failed('web', null, ['email' => 'test@example.com', 'password' => 'wrong']);
            $listener->handle($event);
        }

        // Assert
        // Should trigger exactly one notification at threshold
        Notification::assertSentTo(
            notifiable: null,
            notification: SecurityIncident::class,
            callback: function (SecurityIncident $notification) use ($expectedThreshold) {
                $data = $notification->toArray(null);
                return $data['type'] === 'brute_force' &&
                       $data['attempts'] === $expectedThreshold &&
                       $data['ip'] === '192.168.1.1';
            }
        );

        // Verify rate limiter accuracy
        $this->assertEquals($expectedThreshold, RateLimiter::attempts('failed_login:ip:192.168.1.1'));
    }

    /** @test */
    public function cleanup_operations_are_efficient(): void
    {
        // Arrange
        // Fill up caches and rate limiters
        for ($i = 0; $i < 1000; $i++) {
            Cache::put("test_key_{$i}", "value_{$i}", now()->addMinutes(60));
            RateLimiter::hit("rate_key_{$i}", 3600);
        }

        // Act
        $startTime = microtime(true);

        // Simulate cleanup operations
        Cache::flush();
        for ($i = 0; $i < 1000; $i++) {
            RateLimiter::clear("rate_key_{$i}");
        }

        $endTime = microtime(true);
        $duration = $endTime - $startTime;

        // Assert
        $this->assertLessThan(2.0, $duration, "Cleanup operations took {$duration} seconds");

        // Verify cleanup effectiveness
        $this->assertFalse(Cache::has('test_key_0'));
        $this->assertEquals(0, RateLimiter::attempts('rate_key_0'));
    }
}
