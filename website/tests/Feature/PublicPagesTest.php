<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\GetStartedPageSeeder;
use Database\Seeders\HomePageSeeder;
use Database\Seeders\PageSeeder;
use Database\Seeders\SocialLinksSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();

        $this->seed([
            PageSeeder::class,
            HomePageSeeder::class,
            GetStartedPageSeeder::class,
            SocialLinksSeeder::class,
        ]);
    }

    public function test_public_pages_render_without_motion_effects(): void
    {
        foreach (['/', '/about', '/get-started', '/newsletter', '/offline'] as $path) {
            $response = $this->get($path);

            $response
                ->assertOk()
                ->assertSee('<h1', false)
                ->assertDontSee('<canvas', false)
                ->assertDontSee('requestAnimationFrame', false)
                ->assertDontSee('laravel.com/assets/img/welcome/background.svg', false)
                ->assertDontSee('x-transition', false)
                ->assertDontSee(' transition', false)
                ->assertDontSee('animate-', false);
        }
    }

    public function test_existing_profile_slots_use_the_canonical_static_portrait(): void
    {
        $this->assertFileExists(public_path('assets/avatars/andrej-nankov-profile.png'));

        foreach (['/', '/about', '/newsletter'] as $path) {
            $this->get($path)
                ->assertOk()
                ->assertSee('assets/avatars/andrej-nankov-profile.png', false)
                ->assertDontSee('avatars.githubusercontent.com', false)
                ->assertDontSee('storage/pages/', false);
        }
    }

    public function test_pages_without_profile_slots_do_not_add_the_portrait_to_content(): void
    {
        foreach (['/get-started', '/offline'] as $path) {
            $this->get($path)
                ->assertOk()
                ->assertDontSee('<div class="public-profile-photo', false);
        }
    }

    public function test_public_navigation_and_primary_actions_remain_available(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee(route('about'))
            ->assertSee(route('newsletter'))
            ->assertSee(route('get.started'))
            ->assertSee('Start a conversation');

        $this->get('/newsletter')
            ->assertOk()
            ->assertSee(route('newsletter.subscribe'))
            ->assertSee('name="email"', false)
            ->assertSee('Subscribe');
    }

    public function test_signed_in_header_shows_customer_identity_and_menu(): void
    {
        $customer = User::factory()->create([
            'name' => 'Test Customer',
            'email' => 'customer@example.test',
        ]);

        $avatarUrl = 'https://robohash.org/'.hash('sha256', 'customer@example.test').'.png?size=256x256';

        $this->actingAs($customer)
            ->get('/')
            ->assertOk()
            ->assertSee('Test Customer')
            ->assertSee('customer@example.test')
            ->assertSee(route('orders.index'))
            ->assertSee(route('profile'))
            ->assertSee(route('logout'))
            ->assertSee($avatarUrl, false);
    }
}
