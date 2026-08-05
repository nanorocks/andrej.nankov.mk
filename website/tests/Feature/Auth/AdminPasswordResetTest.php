<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Filament\Auth\Notifications\ResetPassword;
use Filament\Auth\Pages\PasswordReset\RequestPasswordReset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class AdminPasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_reset_request_page_is_reachable(): void
    {
        $this->get('/admin/password-reset/request')->assertOk();
    }

    public function test_password_reset_link_is_sent_to_known_admin(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'andrejnankov@gmail.com',
        ]);

        Livewire::test(RequestPasswordReset::class)
            ->set('data.email', $user->email)
            ->call('request');

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_password_reset_for_unknown_email_does_not_send_notification(): void
    {
        Notification::fake();

        Livewire::test(RequestPasswordReset::class)
            ->set('data.email', 'nobody@example.com')
            ->call('request');

        Notification::assertNothingSent();
    }

    public function test_authenticated_admin_reaches_panel(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin')->assertOk();
    }
}
