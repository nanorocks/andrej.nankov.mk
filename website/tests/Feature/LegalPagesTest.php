<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LegalPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_legal_pages_are_publicly_available(): void
    {
        $pages = [
            'legal.privacy' => 'Privacy Policy',
            'legal.cookies' => 'Cookie Policy',
            'legal.terms' => 'Terms of Sale and Website Use',
            'legal.refunds' => 'Refund and Returns Policy',
            'legal.shipping' => 'Shipping Policy',
        ];

        foreach ($pages as $route => $heading) {
            $this->get(route($route))
                ->assertOk()
                ->assertSee($heading)
                ->assertSee('andrejnankov@gmail.com');
        }
    }

    public function test_privacy_and_cookie_information_describe_payment_and_consent(): void
    {
        $this->get(route('legal.privacy'))
            ->assertSee('Paddle acts as Merchant of Record')
            ->assertSee('Your rights');

        $this->get(route('legal.cookies'))
            ->assertSee('Essential storage')
            ->assertSee('Cookie choices');
    }

    public function test_analytics_script_is_not_loaded_before_consent(): void
    {
        config()->set('services.google_analytics.id', 'G-TEST123');

        $this->get(route('legal.privacy'))
            ->assertOk()
            ->assertDontSee('script async src="https://www.googletagmanager.com', false)
            ->assertSee('andrej_cookie_consent_v1', false);
    }
}
