<?php

namespace Database\Seeders;

use App\Models\SocialLink;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SocialLinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $links = [
            [
                'name' => 'LinkedIn',
                'url' => 'https://www.linkedin.com/in/nanorocks/',
                'icon' => 'linkedin',
                'active' => true,
            ],
            [
                'name' => 'Medium',
                'url' => 'https://medium.com/nanorocks',
                'icon' => 'book-open',
                'active' => true,
            ],
            [
                'name' => 'YouTube',
                'url' => 'https://www.youtube.com/@nanorocks',
                'icon' => 'youtube',
                'active' => true,
            ],
            [
                'name' => 'GitHub',
                'url' => 'https://github.com/nanorocks',
                'icon' => 'github',
                'active' => true,
            ],
            [
                'name' => 'Facebook',
                'url' => 'https://www.facebook.com/nanorocks',
                'icon' => 'facebook',
                'active' => true,
            ],
        ];

        foreach ($links as $link) {
            SocialLink::updateOrCreate(
                ['url' => $link['url']],
                $link
            );
        }
    }
}
