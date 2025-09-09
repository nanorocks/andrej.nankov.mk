<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Nanorocks\LicenseManager\Models\License;

class StatsOverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '10s';

    // protected function getHeading(): ?string
    // {
    //     return 'Analytics';
    // }

    // protected function getDescription(): ?string
    // {
    //     return 'An overview of some analytics.';
    // }

    protected function getStats(): array
    {
        // Calculate stats
        $totalClicks = \App\Models\PanAnalytics::sum('clicks');
        $previousClicks = \App\Models\PanAnalytics::where('created_at', '<', now()->subDay())->sum('clicks');
        $clicksIncrease = $previousClicks > 0 ? (($totalClicks - $previousClicks) / $previousClicks) * 100 : 0;

        $totalSubscribers = \App\Models\NewsletterSubscriber::count();
        $previousSubscribers = \App\Models\NewsletterSubscriber::where('created_at', '<', now()->subDay())->count();
        $subscribersIncrease = $previousSubscribers > 0 ? (($totalSubscribers - $previousSubscribers) / $previousSubscribers) * 100 : 0;

        return [
            Stat::make('Total clicks', $totalClicks)
                ->description(number_format($clicksIncrease, 2) . '% increase')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->icon('heroicon-o-cursor-arrow-rays')
                ->color('success'),

            Stat::make('Subscribers', $totalSubscribers)
                ->description(number_format($subscribersIncrease, 2) . '% increase')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->icon('heroicon-o-users')
                ->color('info'),

            Stat::make('Licenses', License::count())
                ->description('Total generated licenses')
                ->descriptionIcon('heroicon-o-key')
                ->icon('heroicon-o-key')
                ->color('warning'),
        ];
    }
}
