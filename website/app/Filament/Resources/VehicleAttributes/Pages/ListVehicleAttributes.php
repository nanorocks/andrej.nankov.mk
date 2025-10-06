<?php

namespace App\Filament\Resources\VehicleAttributes\Pages;

use App\Filament\Resources\VehicleAttributes\VehicleAttributeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVehicleAttributes extends ListRecords
{
    protected static string $resource = VehicleAttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
