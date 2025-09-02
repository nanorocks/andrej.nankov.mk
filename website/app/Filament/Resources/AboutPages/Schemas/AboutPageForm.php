<?php

namespace App\Filament\Resources\AboutPages\Schemas;

use Filament\Schemas\Schema;

class AboutPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\FileUpload::make('profile_image')
                    ->label('Profile Image')
                    ->image()
                    ->directory('about/profile_images')
                    ->disk('public') // <-- Add this line
                    ->maxSize(2048),
                \Filament\Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required(),
                \Filament\Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->required(),
                \Filament\Forms\Components\MarkdownEditor::make('about_content')
                    ->label('About Content')
                    ->required()
                    ->columnSpan('full'),
                \Filament\Forms\Components\TextInput::make('cv_url')
                    ->label('CV URL')
                    ->url()
                    ->required(),
            ]);
    }
}
