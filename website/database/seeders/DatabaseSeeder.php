<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'andrejnankov@gmail.com'],
            [
                'name' => 'Andrej Nankov',
                'email_verified_at' => now(),
                // Production installs exclude Faker. Generate a non-login
                // password and use the password-reset flow for first access.
                'password' => Hash::make(Str::password(40)),
            ],
        );

        // call all seeders here
        $this->call([
            PageSeeder::class,
            HomePageSeeder::class,
            GetStartedPageSeeder::class,
            SocialLinksSeeder::class,
            StoreProductSeeder::class,
        ]);
    }
}
