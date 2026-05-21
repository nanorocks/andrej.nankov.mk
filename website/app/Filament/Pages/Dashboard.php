<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;

class Dashboard extends BaseDashboard
{
    protected static string|\BackedEnum|null $navigationIcon = LucideIcon::ChartColumn;
    protected static ?string $title = 'Dashboard';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('flushAnalytics')
                ->label('Flush Analytics')
                ->color('danger')
                ->icon('heroicon-o-trash')
                ->requiresConfirmation()
                ->action(fn() => \App\Models\PanAnalytics::truncate()),
        ];
    }

    public function getWidgets(): array
    {
        return [];
    }
}
