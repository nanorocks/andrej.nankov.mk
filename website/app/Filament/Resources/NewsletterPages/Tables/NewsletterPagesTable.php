<?php

namespace App\Filament\Resources\NewsletterPages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class NewsletterPagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
                ->columns([
                    \Filament\Tables\Columns\ImageColumn::make('profile_image')
                        ->label('Profile Image')
                        ->circular(),
                    \Filament\Tables\Columns\TextColumn::make('name')
                        ->label('Name')
                        ->searchable(),
                    \Filament\Tables\Columns\TextColumn::make('role')
                        ->label('Role')
                        ->limit(30),
                    \Filament\Tables\Columns\TextColumn::make('headline')
                        ->label('Headline')
                        ->limit(40),
                    \Filament\Tables\Columns\TextColumn::make('intro')
                        ->label('Intro')
                        ->limit(50),
                    \Filament\Tables\Columns\TextColumn::make('main_content')
                        ->label('Main Content')
                        ->limit(80),
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
