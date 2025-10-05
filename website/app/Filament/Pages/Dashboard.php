<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;

class Dashboard extends BaseDashboard
{
    use HasPageShield;

    protected static string|\BackedEnum|null $navigationIcon = LucideIcon::Car;
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
