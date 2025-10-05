<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class AnalyticsDashboard extends BaseDashboard
{
    use HasPageShield;
    // ...
    protected static string $routePath = 'dashboard';

    protected static ?string $title = 'Dashboard Analytics';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';


    public static function getNavigationGroup(): ?string
    {
        return 'Portfolio Website';
    }
}
