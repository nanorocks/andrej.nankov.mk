<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\SocialLink;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Nanorocks\DatabaseNewsletter\Facades\Newsletter;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Andrej Nankov',
            'email' => 'andrejnankov@gmail.com',
        ]);

        // call all seeders here
        $this->call([
            PageSeeder::class,
            HomePageSeeder::class,
            GetStartedPageSeeder::class,
            SocialLinksSeeder::class,
        ]);
    }
}
