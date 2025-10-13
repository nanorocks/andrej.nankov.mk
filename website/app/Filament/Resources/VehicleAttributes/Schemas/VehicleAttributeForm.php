<?php

namespace App\Filament\Resources\VehicleAttributes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class VehicleAttributeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('vehicle_id')
                    ->relationship('vehicle', 'notes')
                    ->required(),
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
