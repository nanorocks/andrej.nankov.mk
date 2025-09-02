<?php

namespace App\Filament\Resources\NewsletterPages\Schemas;

use Filament\Schemas\Schema;

class NewsletterPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\FileUpload::make('profile_image')
                    ->label('Profile Image')
                    ->image()
                    ->directory('newsletter/profile_images')
                    ->disk('public')
                    ->maxSize(2048),
                \Filament\Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required(),
                \Filament\Forms\Components\TextInput::make('role')
                    ->label('Role')
                    ->required(),
                \Filament\Forms\Components\TextInput::make('headline')
                    ->label('Headline')
                    ->required(),
                \Filament\Forms\Components\Textarea::make('intro')
                    ->label('Intro')
                    ->rows(2)
                    ->required(),
                \Filament\Forms\Components\MarkdownEditor::make('main_content')
                    ->label('Main Content')
                    ->required()
                    ->columnSpan('full'),
            ]);
    }
}
