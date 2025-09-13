<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Actions\Action;

class Dashboard extends BaseDashboard
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-truck';
    protected static ?string $title = 'Car Dashboard';
    protected static string|\UnitEnum|null $navigationGroup = 'Car Management';

    protected static string $routePath = 'car-dashboard';

    public function mount(): void
    {
        // Any initialization logic
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('flushAnalytics')
                ->label('Flush Analytics')
                ->color('danger')
                ->icon('heroicon-o-trash')
                ->requiresConfirmation()
                ->action(fn () => \App\Models\PanAnalytics::truncate()),

        ];
    }

    public function getWidgets(): array
    {
        return [
            // \App\Filament\Widgets\StatsOverview::class,
            // \App\Filament\Widgets\RecentUsers::class,
        ];
    }
}
