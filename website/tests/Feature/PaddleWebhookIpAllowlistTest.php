<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PaddleWebhookIpAllowlistTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('cashier.webhook_secret', null);
        config()->set('services.paddle.enforce_webhook_ip_allowlist', true);
        Cache::forget('paddle.webhook.ipv4_cidrs');
    }

    public function test_it_accepts_a_webhook_from_the_current_paddle_ip_list(): void
    {
        Http::fake([
            'api.paddle.com/ips' => Http::response([
                'data' => ['ipv4_cidrs' => ['203.0.113.42/32']],
            ]),
        ]);

        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.42'])
            ->postJson('/paddle/webhook', ['event_type' => 'test.event'])
            ->assertOk();
    }

    public function test_it_rejects_a_webhook_from_any_other_ip(): void
    {
        Http::fake([
            'api.paddle.com/ips' => Http::response([
                'data' => ['ipv4_cidrs' => ['203.0.113.42/32']],
            ]),
        ]);

        $this->withServerVariables(['REMOTE_ADDR' => '198.51.100.10'])
            ->postJson('/paddle/webhook', ['event_type' => 'test.event'])
            ->assertForbidden();
    }

    public function test_it_fails_closed_when_no_allowlist_can_be_loaded(): void
    {
        Http::fake([
            'api.paddle.com/ips' => Http::response([], 503),
        ]);

        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.42'])
            ->postJson('/paddle/webhook', ['event_type' => 'test.event'])
            ->assertServiceUnavailable();
    }

    public function test_it_uses_the_last_successful_list_when_refresh_fails(): void
    {
        Cache::forever('paddle.webhook.ipv4_cidrs', [
            'cidrs' => ['203.0.113.42/32'],
            'refreshed_at' => 1,
        ]);
        Http::fake([
            'api.paddle.com/ips' => Http::response([], 503),
        ]);

        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.42'])
            ->postJson('/paddle/webhook', ['event_type' => 'test.event'])
            ->assertOk();
    }
}
