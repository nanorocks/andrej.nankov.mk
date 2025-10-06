<?php

namespace App\Filament\Resources\Vehicles\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class VehicleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('owner'),
                TextInput::make('vin'),
                TextInput::make('registration_number'),
                TextInput::make('photo'),
                Select::make('status')
                    ->options([
            'available' => 'Available',
            'rented' => 'Rented',
            'maintenance' => 'Maintenance',
            'sold' => 'Sold',
            'inactive' => 'Inactive',
        ])
                    ->default('available')
                    ->required(),
                DatePicker::make('purchased_at'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
