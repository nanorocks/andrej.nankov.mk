<?php

namespace App\Filament\Resources\Pages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile_image')
                    ->label('Profile Image')
                    ->circular()
                    ->disk('public'),
                TextColumn::make('flag')
                    ->searchable()
                    ->formatStateUsing(fn ($state) => strtoupper($state)),
                TextColumn::make('title')
                    ->searchable(),
                IconColumn::make('is_published')
                    ->boolean(),
                IconColumn::make('include_seo_in_header')
                    ->boolean(),
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
