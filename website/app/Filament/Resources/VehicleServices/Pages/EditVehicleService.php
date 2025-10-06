<?php

namespace App\Filament\Resources\VehicleServices\Pages;

use App\Filament\Resources\VehicleServices\VehicleServiceResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditVehicleService extends EditRecord
{
    protected static string $resource = VehicleServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
