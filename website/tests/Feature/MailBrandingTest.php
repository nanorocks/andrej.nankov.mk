<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MailBrandingTest extends TestCase
{
    use RefreshDatabase;

    public function test_markdown_emails_use_the_brand_theme_and_logo(): void
    {
        $user = User::factory()->create([
            'email' => 'customer@example.test',
        ]);

        $html = (new VerifyEmail)->toMail($user)->render();

        $this->assertStringContainsString('assets/avatars/personal_logo_notes_nankov.png', $html);
        $this->assertStringContainsString('MSc. Andrej Nankov', $html);
        $this->assertStringContainsString('background-color: #090b0e', $html);
        $this->assertStringContainsString('background-color: #ef4444', $html);
    }
}
