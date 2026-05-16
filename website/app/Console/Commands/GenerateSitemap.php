<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Page;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate the sitemap.xml and store it in public/';

    public function handle(): int
    {
        $sitemap = Sitemap::create();

        // Static public routes
        $sitemap->add(
            Url::create(url('/'))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(1.0)
                ->setLastModificationDate(now())
        );

        $sitemap->add(
            Url::create(url('/about'))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.8)
                ->setLastModificationDate(now())
        );

        $sitemap->add(
            Url::create(url('/get-started'))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.7)
                ->setLastModificationDate(now())
        );

        $sitemap->add(
            Url::create(url('/newsletter'))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.6)
                ->setLastModificationDate(now())
        );

        // Published pages
        Page::where('is_published', true)->each(function (Page $page) use ($sitemap) {
            $route = match ($page->flag) {
                'homepage'   => url('/'),
                'about'      => url('/about'),
                'get-started' => url('/get-started'),
                'newsletter' => url('/newsletter'),
                default      => null,
            };

            if ($route) {
                $sitemap->add(
                    Url::create($route)
                        ->setLastModificationDate($page->updated_at)
                );
            }
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('✅ sitemap.xml written to public/sitemap.xml');
        $this->line('Submit it to Google Search Console: ' . url('/sitemap.xml'));

        return self::SUCCESS;
    }
}
