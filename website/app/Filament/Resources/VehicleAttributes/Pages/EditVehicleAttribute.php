<?php

namespace App\Filament\Resources\VehicleAttributes\Pages;

use App\Filament\Resources\VehicleAttributes\VehicleAttributeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVehicleAttribute extends EditRecord
{
    protected static string $resource = VehicleAttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
