<?php

namespace App\Filament\Resources\AboutPages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class AboutPagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('profile_image')
                    ->label('Profile Image')
                    ->circular()
                    ->disk('public'),
                \Filament\Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->limit(40),
                \Filament\Tables\Columns\TextColumn::make('about_content')
                    ->label('About Content')
                    ->limit(80),
                \Filament\Tables\Columns\TextColumn::make('cv_url')
                    ->label('CV URL')
                    ->limit(60),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
