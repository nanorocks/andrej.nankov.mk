<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GetStartedPageSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pages')->insert([
            [
                'flag' => 'get-started',
                'profile_image' => 'https://avatars.githubusercontent.com/u/18250654?v=4',
                'name' => 'Andrej Nankov',
                'title' => null,
                'role' => null,
                'headline' => 'Get Started With Your Startup Idea!',
                'intro' => 'Have an idea but don’t know how to begin? 🚀',
                'content' => '<div class="mt-6 text-left space-y-3 text-gray-300 leading-relaxed">
<p>✔️ Not sure if your idea will work or how to validate it before you commit?</p>
<p>✔️ You’re not a software engineer and need someone technical to guide you.</p>
<p>✔️ You want a clear, actionable plan you can follow to move forward.</p>
<p>✔️ You’re looking for feedback and someone to bounce ideas with.</p>
</div>
<div class="mt-6 text-gray-200 italic">
Imagine having a clear, actionable plan on how to move forward with your idea.
</div>
<div class="mt-8 text-center bg-base rounded-xl p-6 shadow-md">
<h3 class="text-lg font-semibold text-red-400 mb-3">Here’s How It Works</h3>
<p class="text-gray-300">
Book a <span class="font-bold">FREE call</span> with me to talk about your idea.
I’ll help you get started on your journey with practical, actionable advice
tailored to your situation.
</p>
</div>',
                'cv_url' => null,
                'is_published' => 1,
                'include_seo_in_header' => 1,
                'seo_title' => 'Get Started With Your Startup Idea',
                'seo_description' => 'Get started with your startup idea! Book a free call with Andrej Nankov to validate your idea, get technical guidance, and receive actionable advice tailored to your startup journey.',
                'seo_keywords' => 'Andrej Nankov, Get Started, Startup Idea, Free Call, CTO, Technical Guidance, Entrepreneurship, Software Engineering',
                'seo_author' => 'Andrej Nankov',
                'seo_robots' => 'index, follow',
                'og_title' => 'Get Started With Your Startup Idea',
                'og_description' => 'Book a free call with Andrej Nankov to validate your startup idea, get technical guidance, and actionable advice tailored to your journey.',
                'og_type' => 'website',
                'og_url' => 'https://andrej.nankov.mk/get-started',
                'og_image' => 'https://avatars.githubusercontent.com/u/18250654?v=4',
                'og_image_alt' => 'Andrej Nankov Profile Picture',
                'og_site_name' => 'Andrej Nankov',
                'twitter_card' => 'summary_large_image',
                'twitter_title' => 'Get Started With Your Startup Idea',
                'twitter_description' => 'Book a free call with Andrej Nankov to validate your startup idea, get technical guidance, and actionable advice tailored to your journey.',
                'twitter_image' => 'https://avatars.githubusercontent.com/u/18250654?v=4',
                'twitter_image_alt' => 'Andrej Nankov Profile Picture',
                'twitter_creator' => '@nanorocks',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
