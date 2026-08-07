<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_user_without_uploaded_photo_gets_a_stable_robohash_avatar(): void
    {
        $user = new User([
            'name' => 'Test Customer',
            'email' => 'Customer@Example.test ',
        ]);

        $expectedHash = hash('sha256', 'customer@example.test');

        $this->assertSame(
            "https://robohash.org/{$expectedHash}.png?size=256x256",
            $user->profile_photo_url,
        );
        $this->assertStringNotContainsString('customer@example.test', $user->profile_photo_url);
    }
}
