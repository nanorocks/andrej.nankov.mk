<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomePageSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pages')->insert([
            // ...existing about and newsletter records...
            [
                'id' => 3,
                'flag' => 'homepage',
                'profile_image' => 'https://avatars.githubusercontent.com/u/18250654?v=4',
                'name' => 'Andrej Nankov',
                'title' => null,
                'role' => 'More than just an engineer.',
                'headline' => 'Helping founders and companies get started with their software ideas 🚀',
                'intro' => null,
                'main_content' => null,
                'content' => '<div class="space-y-2 text-center">
<p>I partner with startups and companies to turn complex ideas into reliable, scalable software solutions.</p>
<p>Let’s connect if you’re looking for a <span class="font-semibold">fractional CTO</span>, project consultant, or a senior engineer to help you build and scale your next big idea.</p>
</div>',
                'cv_url' => null,
                'is_published' => 1,
                'include_seo_in_header' => 1,
                'seo_title' => 'Partnering with Startups & Companies | Fractional CTO, Project Consultant, Senior Engineer',
                'seo_description' => 'I partner with startups and companies to turn complex ideas into reliable, scalable software solutions.',
                'seo_keywords' => 'Andrej Nankov, Fractional CTO, Startup Consultant, Senior Engineer, Software Solutions, Startups, Scalable Software',
                'seo_author' => 'Andrej Nankov',
                'seo_robots' => 'index, follow',
                'og_title' => 'Partnering with Startups & Companies | Fractional CTO, Project Consultant, Senior Engineer',
                'og_description' => 'I partner with startups and companies to turn complex ideas into reliable, scalable software solutions.',
                'og_type' => 'website',
                'og_url' => 'https://andrej.nankov.mk',
                'og_image' => 'https://avatars.githubusercontent.com/u/18250654?v=4',
                'og_image_alt' => 'Andrej Nankov Profile Picture',
                'og_site_name' => 'Andrej Nankov',
                'twitter_card' => 'summary_large_image',
                'twitter_title' => 'Partnering with Startups & Companies | Fractional CTO, Project Consultant, Senior Engineer',
                'twitter_description' => 'I partner with startups and companies to turn complex ideas into reliable, scalable software solutions.',
                'twitter_image' => 'https://avatars.githubusercontent.com/u/18250654?v=4',
                'twitter_image_alt' => 'Andrej Nankov Profile Picture',
                'twitter_creator' => '@nanorocks',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
