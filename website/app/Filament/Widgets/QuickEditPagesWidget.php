<?php

namespace App\Filament\Widgets;

use App\Filament\Pages\Cms\About;
use App\Filament\Pages\Cms\GetStarted;
use App\Filament\Pages\Cms\Homepage;
use App\Filament\Pages\Cms\Newsletter;
use App\Models\Page;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class QuickEditPagesWidget extends StatsOverviewWidget
{
    protected static ?int $sort = -10;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $pages = Page::query()
            ->whereIn('flag', ['homepage', 'about', 'newsletter', 'get-started'])
            ->get()
            ->keyBy('flag');

        return [
            $this->stat('homepage', 'Homepage', Homepage::getUrl(), 'heroicon-o-home', $pages),
            $this->stat('about', 'About', About::getUrl(), 'heroicon-o-information-circle', $pages),
            $this->stat('newsletter', 'Newsletter', Newsletter::getUrl(), 'heroicon-o-envelope', $pages),
            $this->stat('get-started', 'Get Started', GetStarted::getUrl(), 'heroicon-o-rocket-launch', $pages),
        ];
    }

    private function stat(string $flag, string $label, string $url, string $icon, $pages): Stat
    {
        $page = $pages[$flag] ?? null;
        $published = (bool) ($page?->is_published);

        return Stat::make($label, $published ? 'Published' : 'Draft')
            ->description('Click to edit')
            ->descriptionIcon('heroicon-o-pencil-square')
            ->icon($icon)
            ->color($published ? 'success' : 'gray')
            ->url($url);
    }
}
