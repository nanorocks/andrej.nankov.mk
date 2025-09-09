<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Actions\Action;

class Dashboard extends BaseDashboard
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home';
    protected static ?string $title = 'Dashboard';
    protected static string|\UnitEnum|null $navigationGroup = 'Other';

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
            \App\Filament\Widgets\StatsOverview::class,
            // \App\Filament\Widgets\RecentUsers::class,
        ];
    }
}
