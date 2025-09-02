<?php

namespace Database\Seeders;

use App\Models\AboutPage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AboutPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutPage::updateOrCreate(
            ['name' => 'Andrej Nankov'],
            [
                'profile_image' => 'https://avatars.githubusercontent.com/u/18250654?v=4',
                'name' => 'Andrej Nankov',
                'title' => 'Software Engineer | M.Sc. | YOE +7',
                'about_content' => '
                    <ul class="list list-inside mb-4">
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
                    </div>
                ',
                'cv_url' => 'https://bit.ly/4lJ7bJG',
            ]
        );
    }
}
