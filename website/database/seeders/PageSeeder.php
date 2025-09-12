<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pages')->insert([
            [
                'id' => 1,
                'flag' => 'about',
                'profile_image' => 'pages/01K4YGCMYHZRYQ601TY2VYC9EN.png',
                'name' => 'Andrej Nankov',
                'title' => 'Software Engineer | M.Sc. | YOE +7',
                'role' => null,
                'headline' => null,
                'intro' => null,
                'content' => '<ul class="list list-inside mb-4">
<li>
My work is guided by <span class="font-semibold text-red-400">Discipline</span>,
<span class="font-semibold text-red-400">Passion</span>, and
<span class="font-semibold text-red-400">Focus</span>.
</li>
</ul>
<p>I partner with startups and companies to turn complex ideas into reliable, scalable software solutions. With over 7 years of hands-on experience in <span class="font-semibold">FinTech, E-commerce, Telecommunications, and Digital Transformation</span>, I bring a mix of technical expertise and strategic guidance to every project.</p>
<p>I specialize in <span class="font-semibold">technical consulting, system architecture, and hands-on development</span>. From planning and design to deployment and optimization, I help teams make the right decisions early, avoid costly mistakes, and deliver software that truly works for their business.</p>
<p>My expertise spans both frontend and backend development, with experience across the JavaScript, PHP, and Java ecosystems. I enjoy creating clean, efficient code, implementing best practices like SOLID principles and design patterns, and mentoring teams to grow.</p>
<p>Beyond client work, I share knowledge through writing, blogging, and content creation about software engineering, finance, and technology trends. I’m also passionate about exploring new places and documenting my travels through video content.</p>
<div class="mt-8 text-lg font-medium text-red-400 flex items-center gap-2">
🚀 If you’re looking for a fractional CTO, project consultant, or a senior engineer,
I’d love to collaborate on turning your vision into reality.
</div>',
                'cv_url' => 'https://bit.ly/4lJ7bJG',
                'is_published' => 1,
                'include_seo_in_header' => 1,
                'seo_title' => 'About Andrej Nankov',
                'seo_description' => 'Learn about Andrej Nankov, a Software Engineer with 7+ years of experience in FinTech, E-commerce, Telecommunications, and Digital Transformation.',
                'seo_keywords' => 'Andrej Nankov, Software Engineer, Technical Consultant, Full Stack Developer, FinTech, E-commerce, Digital Transformation',
                'seo_author' => 'Andrej Nankov',
                'seo_robots' => 'index, follow',
                'og_title' => 'About Andrej Nankov',
                'og_description' => 'Learn about Andrej Nankov, a Software Engineer with 7+ years of experience in FinTech, E-commerce, Telecommunications, and Digital Transformation.',
                'og_type' => 'website',
                'og_url' => 'https://andrej.nankov.mk/about',
                'og_image' => null,
                'og_image_alt' => null,
                'og_site_name' => 'Andrej Nankov',
                'twitter_card' => 'summary_large_image',
                'twitter_title' => 'About Andrej Nankov',
                'twitter_description' => 'Learn about Andrej Nankov, a Software Engineer with 7+ years of experience in FinTech, E-commerce, Telecommunications, and Digital Transformation.',
                'twitter_image' => null,
                'twitter_image_alt' => null,
                'twitter_creator' => '@nanorocks',
                'created_at' => '2025-09-02 23:13:14',
                'updated_at' => '2025-09-12 08:24:08',
            ],
            [
                'id' => 2,
                'flag' => 'newsletter',
                'profile_image' => 'pages/01K4YGG09AS2MCJP2NG0MXX618.png',
                'name' => 'Andrej Nankov',
                'title' => null,
                'role' => 'More than just an engineer.',
                'headline' => 'Subscribe to my Newsletter',
                'intro' => 'Get the latest updates, articles, and insights directly to your inbox. No spam, ever.',
                'content' => '<p>Join a growing community of founders, engineers, and tech enthusiasts who receive my curated
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
<p class="mt-2 font-semibold text-red-400">Enter your email below to join!</p>',
                'cv_url' => null,
                'is_published' => 1,
                'include_seo_in_header' => 1,
                'seo_title' => 'Subscribe to Newsletter - Andrej Nankov | More than just an engineer.',
                'seo_description' => "Join Andrej Nankov's newsletter for founders, engineers, and tech enthusiasts. Get updates, articles, insights, and exclusive resources on software engineering and entrepreneurship. No spam.",
                'seo_keywords' => 'Andrej Nankov, Newsletter, Software Engineering, Entrepreneurship, Tech Updates, Startups',
                'seo_author' => 'Andrej Nankov',
                'seo_robots' => 'index, follow',
                'og_title' => 'Subscribe to Newsletter',
                'og_description' => "Join Andrej Nankov's newsletter for founders, engineers, and tech enthusiasts. Get updates, articles, insights, and exclusive resources on software engineering and entrepreneurship. No spam.",
                'og_type' => 'website',
                'og_url' => 'https://andrej.nankov.mk/newsletter',
                'og_image' => null,
                'og_image_alt' => null,
                'og_site_name' => 'Andrej Nankov',
                'twitter_card' => 'summary_large_image',
                'twitter_title' => 'Subscribe to Newsletter',
                'twitter_description' => "Join Andrej Nankov's newsletter for founders, engineers, and tech enthusiasts. Get updates, articles, insights, and exclusive resources on software engineering and entrepreneurship. No spam.",
                'twitter_image' => null,
                'twitter_image_alt' => null,
                'twitter_creator' => '@nanorocks',
                'created_at' => '2025-09-11 21:41:19',
                'updated_at' => '2025-09-12 08:25:58',
            ],
        ]);
    }
}
