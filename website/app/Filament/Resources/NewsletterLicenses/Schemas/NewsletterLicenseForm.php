<?php

namespace App\Filament\Resources\NewsletterLicenses\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use App\View\Components\LicenseKeyInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\CodeEditor\Enums\Language;

class NewsletterLicenseForm
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

                \Filament\Forms\Components\CodeEditor::make('metadata')
                    ->label('Metadata (JSON)')
                    ->language(Language::Json)
                    ->nullable(),
            ]);
    }
}
