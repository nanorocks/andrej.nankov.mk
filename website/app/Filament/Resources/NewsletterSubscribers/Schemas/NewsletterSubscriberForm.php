<?php

namespace App\Filament\Resources\NewsletterSubscribers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class NewsletterSubscriberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('attributes')
                    ->label('Attributes')
                    ->placeholder('Enter valid JSON...')
                    ->extraAttributes(['class' => 'font-mono'])
                    ->rule('json'),
                Toggle::make('subscribed')
                    ->required(),
            ]);
    }
}
