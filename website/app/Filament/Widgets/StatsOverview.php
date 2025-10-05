<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Nanorocks\LicenseManager\Models\License;
use Filament\Widgets\StatsOverviewWidget\Stat;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class StatsOverview extends StatsOverviewWidget
{
    use HasWidgetShield;

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
        // Use Carbon for date handling
        $yesterday = now()->subDay();

        // Aggregate clicks
        $totalClicks = \App\Models\PanAnalytics::sum('clicks');
        $previousClicks = \App\Models\PanAnalytics::where('created_at', '<', $yesterday)->sum('clicks');
        $clicksIncrease = $previousClicks > 0 ? (($totalClicks - $previousClicks) / $previousClicks) * 100 : 0;

        // Aggregate subscribers
        $totalSubscribers = \App\Models\NewsletterSubscriber::count();
        $previousSubscribers = \App\Models\NewsletterSubscriber::where('created_at', '<', $yesterday)->count();
        $subscribersIncrease = $previousSubscribers > 0 ? (($totalSubscribers - $previousSubscribers) / $previousSubscribers) * 100 : 0;

        // Licenses count
        $licensesCount = License::count();

        return [
            Stat::make('Total Clicks', $totalClicks)
                ->description($previousClicks > 0 ? number_format($clicksIncrease, 2) . '% increase' : 'No previous data')
                ->descriptionIcon($clicksIncrease >= 0 ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down')
                ->icon('heroicon-o-cursor-arrow-rays')
                ->color($clicksIncrease >= 0 ? 'success' : 'danger'),

            Stat::make('Subscribers', $totalSubscribers)
                ->description($previousSubscribers > 0 ? number_format($subscribersIncrease, 2) . '% increase' : 'No previous data')
                ->descriptionIcon($subscribersIncrease >= 0 ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down')
                ->icon('heroicon-o-users')
                ->color($subscribersIncrease >= 0 ? 'info' : 'danger'),

            Stat::make('Licenses', $licensesCount)
                ->description('Total generated licenses')
                ->descriptionIcon('heroicon-o-key')
                ->icon('heroicon-o-key')
                ->color('warning'),
        ];
    }
}
