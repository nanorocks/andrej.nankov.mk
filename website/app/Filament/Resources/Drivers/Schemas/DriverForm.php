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
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('license_number')
                    ->required(),
                TextInput::make('license_category'),
                DatePicker::make('license_issued_at'),
                DatePicker::make('license_expires_at'),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('address'),
                DatePicker::make('date_of_birth'),
                Select::make('status')
                    ->options(['active' => 'Active', 'inactive' => 'Inactive', 'suspended' => 'Suspended'])
                    ->default('active')
                    ->required(),
                TextInput::make('attributes'),
            ]);
    }
}
