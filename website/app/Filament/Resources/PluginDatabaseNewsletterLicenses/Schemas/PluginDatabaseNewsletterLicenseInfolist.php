<?php

namespace App\Filament\Resources\PluginDatabaseNewsletterLicenses\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class PluginDatabaseNewsletterLicenseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('license_key')->label('License Key')->disabled(),
                TextInput::make('assigned_to')->label('Assigned To')->disabled(),
                TextInput::make('active')->label('Active')->disabled(),
                TextInput::make('expires_at')->label('Expires At')->disabled(),
                Textarea::make('metadata')->label('Metadata')->disabled(),
            ]);
    }
}
