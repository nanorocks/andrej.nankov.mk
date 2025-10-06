<?php

namespace App\Filament\Resources\VehicleServices\Pages;

use App\Filament\Resources\VehicleServices\VehicleServiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVehicleServices extends ListRecords
{
    protected static string $resource = VehicleServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
