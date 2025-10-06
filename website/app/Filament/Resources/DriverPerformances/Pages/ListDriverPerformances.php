<?php

namespace App\Filament\Resources\DriverPerformances\Pages;

use App\Filament\Resources\DriverPerformances\DriverPerformanceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDriverPerformances extends ListRecords
{
    protected static string $resource = DriverPerformanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
