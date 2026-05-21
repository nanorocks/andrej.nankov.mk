<?php

namespace App\Filament\Widgets;

use App\Filament\Pages\Cms\About;
use App\Filament\Pages\Cms\GetStarted;
use App\Filament\Pages\Cms\Homepage;
use App\Filament\Pages\Cms\Newsletter;
use App\Models\Page;
use Filament\Widgets\Widget;

class SeoHealthWidget extends Widget
{
    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = 'full';

    protected string $view = 'filament.widgets.seo-health';

    /** @return array<int, array<string, mixed>> */
    public function getRows(): array
    {
        $config = [
            ['flag' => 'homepage', 'label' => 'Homepage', 'url' => Homepage::getUrl()],
            ['flag' => 'about', 'label' => 'About', 'url' => About::getUrl()],
            ['flag' => 'newsletter', 'label' => 'Newsletter', 'url' => Newsletter::getUrl()],
            ['flag' => 'get-started', 'label' => 'Get Started', 'url' => GetStarted::getUrl()],
        ];

        $pages = Page::query()
            ->whereIn('flag', array_column($config, 'flag'))
            ->get()
            ->keyBy('flag');

        return array_map(function (array $row) use ($pages) {
            $page = $pages[$row['flag']] ?? null;

            return [
                'label' => $row['label'],
                'url' => $row['url'],
                'checks' => [
                    'seo_title' => filled($page?->seo_title),
                    'seo_description' => filled($page?->seo_description),
                    'og_image' => filled($page?->og_image),
                    'twitter_image' => filled($page?->twitter_image),
                ],
            ];
        }, $config);
    }
}
