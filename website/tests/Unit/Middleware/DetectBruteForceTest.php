<?php

declare(strict_types=1);

namespace Tests\Unit\Middleware;

use App\Http\Middleware\DetectBruteForce;
use App\Notifications\SecurityIncident;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class DetectBruteForceTest extends TestCase
{
    protected DetectBruteForce $middleware;

    protected function setUp(): void
    {
        parent::setUp();

        $this->middleware = new DetectBruteForce();

        // Clear rate limiters and cache before each test
        RateLimiter::clear('suspicious_activity:192.168.1.1');
        RateLimiter::clear('suspicious_activity:10.0.0.1');
        RateLimiter::clear('suspicious_activity:127.0.0.1');
        Cache::flush();
    }

    /** @test */
    public function it_allows_normal_traffic_through(): void
    {
        // Arrange
        $request = Request::create('https://andrej.nankov.mk/test', 'GET');
        $request->server->set('REMOTE_ADDR', '192.168.1.1');
        $next = fn($request) => new Response('OK', 200);

        // Act
        $response = $this->middleware->handle($request, $next);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getContent());
    }

    /** @test */
    public function it_blocks_requests_when_rate_limit_exceeded(): void
    {
        // Arrange
        Notification::fake();

        $request = Request::create('https://andrej.nankov.mk/test', 'GET');
        $request->server->set('REMOTE_ADDR', '192.168.1.1');
        $request->headers->set('User-Agent', 'Test Browser');

        // Hit the rate limit first (50 times)
        for ($i = 0; $i < 50; $i++) {
            RateLimiter::hit('suspicious_activity:192.168.1.1', 60);
        }

        $next = fn($request) => new Response('Should not reach here', 200);

        // Act
        $response = $this->middleware->handle($request, $next);

        // Assert
        $this->assertEquals(429, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('Too many requests. Please try again later.', $responseData['message']);

        // Should send notification
        Notification::assertSentOnDemand(SecurityIncident::class);
    }

    /** @test */
    public function it_does_not_send_duplicate_notifications(): void
    {
        // Arrange
        Notification::fake();

        $request = Request::create('https://andrej.nankov.mk/test', 'GET');
        $request->server->set('REMOTE_ADDR', '192.168.1.1');

        // Hit rate limit first
        for ($i = 0; $i < 50; $i++) {
            RateLimiter::hit('suspicious_activity:192.168.1.1', 60);
        }

        $next = fn($request) => new Response('OK', 200);

        // First request should send notification
        $this->middleware->handle($request, $next);

        // Second request should not send duplicate notification
        $response = $this->middleware->handle($request, $next);

        // Assert
        $this->assertEquals(429, $response->getStatusCode());

        // Should only send one notification due to caching
        Notification::assertSentTimes(SecurityIncident::class, 1);
    }

    /** @test */
    public function it_creates_correct_incident_data(): void
    {
        // Arrange
        Notification::fake();

        $request = Request::create('https://andrej.nankov.mk/login', 'POST');
        $request->server->set('REMOTE_ADDR', '10.0.0.1');
        $request->headers->set('User-Agent', 'Mozilla/5.0 (Test)');

        // Hit rate limit first
        for ($i = 0; $i < 50; $i++) {
            RateLimiter::hit('suspicious_activity:10.0.0.1', 60);
        }

        $next = fn($request) => new Response('OK', 200);

        // Act
        $this->middleware->handle($request, $next);

        // Assert
        Notification::assertSentOnDemand(
            SecurityIncident::class,
            function (SecurityIncident $notification) {
                $data = $notification->toArray(null);
                return $data['type'] === 'suspicious_activity' &&
                       $data['ip'] === '10.0.0.1' &&
                       $data['user_agent'] === 'Mozilla/5.0 (Test)' &&
                       $data['url'] === 'https://andrej.nankov.mk/login';
            }
        );
    }

    /** @test */
    public function it_uses_correct_rate_limiting_parameters(): void
    {
        // Arrange
        $request = Request::create('https://andrej.nankov.mk/test', 'GET');
        $request->server->set('REMOTE_ADDR', '127.0.0.1');
        $next = fn($request) => new Response('OK', 200);

        // Act - Make 50 requests through middleware
        for ($i = 0; $i < 50; $i++) {
            $response = $this->middleware->handle($request, $next);
            $this->assertEquals(200, $response->getStatusCode());
        }

        // Should have exactly 50 attempts now
        $this->assertEquals(50, RateLimiter::attempts('suspicious_activity:127.0.0.1'));

        // 51st request should block (tooManyAttempts should be true)
        $response = $this->middleware->handle($request, $next);
        $this->assertEquals(429, $response->getStatusCode());
    }
}
