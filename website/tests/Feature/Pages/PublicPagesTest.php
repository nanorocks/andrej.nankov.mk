<?php

namespace Tests\Feature\Pages;

use Database\Seeders\GetStartedPageSeeder;
use Database\Seeders\HomePageSeeder;
use Database\Seeders\PageSeeder;
use Database\Seeders\SocialLinksSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PageSeeder::class);
        $this->seed(HomePageSeeder::class);
        $this->seed(GetStartedPageSeeder::class);
        $this->seed(SocialLinksSeeder::class);
    }

    public function test_home_page_renders(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_about_page_renders(): void
    {
        $this->get('/about')->assertOk();
    }

    public function test_get_started_page_renders(): void
    {
        $this->get('/get-started')->assertOk();
    }

    public function test_newsletter_page_renders(): void
    {
        $this->get('/newsletter')->assertOk();
    }

    public function test_offline_page_renders(): void
    {
        $this->get('/offline')->assertOk();
    }

    public function test_dashboard_route_is_gone(): void
    {
        $this->get('/dashboard')->assertNotFound();
    }

    public function test_profile_route_is_gone(): void
    {
        $this->get('/profile')->assertNotFound();
    }

    public function test_logout_standalone_route_is_gone(): void
    {
        $this->get('/logout')->assertNotFound();
    }

    public function test_admin_redirects_guests_to_filament_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_admin_preserves_https_behind_a_trusted_proxy(): void
    {
        $this->withServerVariables([
            'HTTP_HOST' => 'example.ngrok-free.app',
            'HTTP_X_FORWARDED_HOST' => 'example.ngrok-free.app',
            'HTTP_X_FORWARDED_PORT' => '443',
            'HTTP_X_FORWARDED_PROTO' => 'https',
            'REMOTE_ADDR' => '172.21.0.1',
        ])->get('/admin')
            ->assertRedirect('https://example.ngrok-free.app/admin/login');
    }

    public function test_admin_login_page_renders(): void
    {
        $this->get('/admin/login')->assertOk();
    }

    public function test_admin_password_reset_request_page_renders(): void
    {
        $this->get('/admin/password-reset/request')->assertOk();
    }
}
