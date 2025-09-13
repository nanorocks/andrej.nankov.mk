<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class AnalyticsDashboard extends BaseDashboard
{
    // ...
    protected static string $routePath = 'dashboard';

    protected static ?string $title = 'Analytics';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';


    public static function getNavigationGroup(): ?string
    {
        return 'Portfolio Website';
    }
}
