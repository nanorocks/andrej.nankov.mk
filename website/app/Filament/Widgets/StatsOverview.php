<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        $yesterday = now()->subDay();

        $totalClicks = \App\Models\PanAnalytics::sum('clicks');
        $previousClicks = \App\Models\PanAnalytics::where('created_at', '<', $yesterday)->sum('clicks');
        $clicksIncrease = $previousClicks > 0 ? (($totalClicks - $previousClicks) / $previousClicks) * 100 : 0;

        $totalSubscribers = \App\Models\NewsletterSubscriber::count();
        $previousSubscribers = \App\Models\NewsletterSubscriber::where('created_at', '<', $yesterday)->count();
        $subscribersIncrease = $previousSubscribers > 0 ? (($totalSubscribers - $previousSubscribers) / $previousSubscribers) * 100 : 0;

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
        ];
    }
}
