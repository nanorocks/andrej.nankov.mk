<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->unique(table: 'users', column: 'email', ignoreRecord: true),

                FileUpload::make('profile_photo_path')
                    ->label('Profile Photo')
                    ->image()
                    ->disk('public')
                    ->visibility('public')
                    ->maxSize(2048),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->revealable()
                    ->required(fn (string $context) => $context === 'create')
                    ->dehydrated(fn ($state) => filled($state))
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                    ->minLength(8),

                DateTimePicker::make('email_verified_at')
                    ->label('Email verified at')
                    ->seconds(false)
                    ->native(false)
                    ->nullable()
                    ->disabled(),

                // Spatie roles (optional, since model uses HasRoles)
                Select::make('roles')
                    ->label('Roles')
                    ->multiple()
                    ->preload()
                    ->relationship('roles', 'name'),
            ])
            ->columns(2);
    }
}
