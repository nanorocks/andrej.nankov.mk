<?php

namespace App\Filament\Resources\PluginDatabaseNewsletterLicenses\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use App\View\Components\LicenseKeyInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;

class PluginDatabaseNewsletterLicenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                LicenseKeyInput::make('license_key')
                    ->label('License Key')
                    ->required()->unique(ignoreRecord: true),

                TextInput::make('assigned_to')
                    ->label('Assigned To')
                    ->required()
                    ->maxLength(255),

                Toggle::make('active')
                    ->label('Active')
                    ->default(true),

                DateTimePicker::make('expires_at')
                    ->label('Expires At')
                    ->nullable(),

                Textarea::make('metadata')
                    ->label('Metadata (JSON)')
                    ->json()
                    ->nullable(),
            ]);
    }
}
