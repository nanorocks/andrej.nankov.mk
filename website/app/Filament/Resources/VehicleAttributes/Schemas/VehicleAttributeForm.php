<?php

namespace App\Filament\Resources\VehicleAttributes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class VehicleAttributeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('vehicle_id')
                    ->required()
                    ->numeric(),
                TextInput::make('attribute')
                    ->required(),
                Textarea::make('value')
                    ->columnSpanFull(),
                TextInput::make('value_type')
                    ->required()
                    ->default('string'),
                TextInput::make('meta'),
            ]);
    }
}
