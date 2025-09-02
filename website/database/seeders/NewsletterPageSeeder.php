<?php

namespace Database\Seeders;

use App\Models\NewsletterPage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NewsletterPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NewsletterPage::updateOrCreate(
            ['name' => 'Andrej Nankov'],
            [
                'profile_image' => 'https://avatars.githubusercontent.com/u/18250654?v=4',
                'role' => 'More than just an engineer.',
                'headline' => 'Subscribe to my Newsletter',
                'intro' => 'Get the latest updates, articles, and insights directly to your inbox. No spam, ever.',
                'main_content' => '
                    <p>Join a growing community of founders, engineers, and tech enthusiasts who receive my curated
                    newsletter every month. I share actionable advice, deep dives into software engineering,
                    entrepreneurship stories, and exclusive resources you won\'t find anywhere else.</p>
                    <ul class="list-disc ml-6 mt-2">
                        <li>Fresh articles on building and scaling software products</li>
                        <li>Behind-the-scenes lessons from my own startup journey</li>
                        <li>Tips for navigating the tech industry and career growth</li>
                        <li>Early access to new tools, guides, and events</li>
                        <li>Occasional personal stories and reflections</li>
                    </ul>
                    <p class="mt-2">Whether you\'re a founder, developer, or just passionate about technology, this
                    newsletter is designed to inspire and inform. I respect your inbox - no spam, just quality
                    content.</p>
                    <p class="mt-2 font-semibold text-red-400">Enter your email below to join!</p>
                ',
            ]
        );
    }
}
