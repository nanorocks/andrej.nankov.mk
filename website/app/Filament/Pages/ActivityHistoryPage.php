<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class ActivityHistoryPage extends Page
{
    use HasPageShield;

    protected string $view = 'filament.pages.activity-history-page';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'Activity History';
    protected static ?string $title = 'Activity History';
}
