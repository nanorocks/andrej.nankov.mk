<?php

namespace App\Filament\Pages;

use App\Models\Activity;
use Filament\Pages\Page;

class ActivityHistoryPage extends Page
{
    protected string $view = 'filament.pages.activity-history-page';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'Activity History';
    protected static ?string $title = 'Activity History';

    public function getActivities()
    {
        return Activity::query()->latest()->paginate(10);
    }
}
