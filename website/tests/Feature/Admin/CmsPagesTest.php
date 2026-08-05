<?php

namespace Tests\Feature\Admin;

use App\Filament\Pages\Cms\About;
use App\Filament\Pages\Cms\GetStarted;
use App\Filament\Pages\Cms\Homepage;
use App\Filament\Pages\Cms\Newsletter;
use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CmsPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_admin_can_reach_homepage_editor(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/admin/homepage')
            ->assertOk();
    }

    public function test_authenticated_admin_can_reach_about_editor(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/admin/about')
            ->assertOk();
    }

    public function test_authenticated_admin_can_reach_newsletter_editor(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/admin/newsletter')
            ->assertOk();
    }

    public function test_authenticated_admin_can_reach_get_started_editor(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/admin/get-started')
            ->assertOk();
    }

    public function test_guests_are_redirected_from_each_editor(): void
    {
        foreach (['/admin/homepage', '/admin/about', '/admin/newsletter', '/admin/get-started'] as $path) {
            $this->get($path)->assertRedirect('/admin/login');
        }
    }

    public function test_save_updates_existing_homepage_row_by_flag(): void
    {
        $user = User::factory()->create();
        $existing = Page::create([
            'flag' => 'homepage',
            'name' => 'Old Name',
            'is_published' => true,
        ]);

        Livewire::actingAs($user)
            ->test(Homepage::class)
            ->set('data.name', 'Brand New Name')
            ->call('save');

        $this->assertSame(1, Page::where('flag', 'homepage')->count());
        $this->assertSame('Brand New Name', $existing->fresh()->name);
    }

    public function test_save_creates_row_on_first_visit_for_each_flag(): void
    {
        $user = User::factory()->create();
        $this->assertSame(0, Page::count());

        foreach ([Homepage::class, About::class, Newsletter::class, GetStarted::class] as $page) {
            $this->actingAs($user)->get($page::getUrl())->assertOk();
        }

        $this->assertSame(
            ['homepage', 'about', 'newsletter', 'get-started'],
            Page::query()->orderBy('id')->pluck('flag')->all()
        );
    }

    public function test_dashboard_renders_with_all_widgets(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/admin')
            ->assertOk();
    }
}
