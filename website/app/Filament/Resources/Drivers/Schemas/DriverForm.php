<?php

namespace App\Filament\Resources\Drivers\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DriverForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('license_number')
                    ->required(),
                Select::make('license_category')
                    ->label('License Category')
                    ->options([
                        'A' => 'Motorcycles',
                        'B' => 'Cars',
                        'C' => 'Trucks',
                        'D' => 'Buses',
                        'E' => 'Trailers',
                        'F' => 'Agricultural Vehicles',
                    ])
                    ->multiple()
                    ->required(),
                DatePicker::make('license_issued_at'),
                DatePicker::make('license_expires_at')
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                TextInput::make('address'),
                DatePicker::make('date_of_birth')->required(),
                Select::make('status')
                    ->options(['active' => 'Active', 'inactive' => 'Inactive', 'suspended' => 'Suspended'])
                    ->default('active')
                    ->required(),
                TextInput::make('attributes'),
            ]);
    }
}
