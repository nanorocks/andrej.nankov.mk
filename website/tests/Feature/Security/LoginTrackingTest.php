<?php

namespace Tests\Feature\Security;

use Illuminate\Auth\Events\Failed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class LoginTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_custom_request_and_failed_login_tracking_are_disabled(): void
    {
        $ip = '127.0.0.1';
        $email = 'owner@example.com';

        $this->withServerVariables(['REMOTE_ADDR' => $ip])
            ->get('/admin/login')
            ->assertOk();

        event(new Failed('web', null, [
            'email' => $email,
            'password' => 'invalid-password',
        ]));

        $this->assertSame(0, RateLimiter::attempts("suspicious_activity:{$ip}"));
        $this->assertSame(0, RateLimiter::attempts("failed_login:ip:{$ip}"));
        $this->assertSame(0, RateLimiter::attempts("failed_login:email:{$email}"));
    }
}
