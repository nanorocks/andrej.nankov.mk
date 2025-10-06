<?php

namespace App\Filament\Resources\DriverPerformances\Pages;

use App\Filament\Resources\DriverPerformances\DriverPerformanceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDriverPerformance extends EditRecord
{
    protected static string $resource = DriverPerformanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
