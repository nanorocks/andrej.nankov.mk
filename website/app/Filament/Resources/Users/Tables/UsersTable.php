<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\ExportBulkAction;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile_photo_path')
                    ->label('Profile Image')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('email_verified_at')
                    ->label('Email Verified At')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('roles.name')
                    ->label('Roles')
                    ->badge()
                    ->separator(', ')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()->exports([
                        ExcelExport::make()->withColumns([
                            // Export only real DB columns (exclude computed `avatar`)
                            Column::make('name')->heading('Name'),
                            Column::make('email')->heading('Email'),
                            Column::make('email_verified_at')->heading('Email Verified At'),
                            Column::make('profile_photo_path')->heading('Profile Photo Path'),
                            Column::make('two_factor_confirmed_at')->heading('2FA Confirmed At'),
                            Column::make('created_at')->heading('Created At'),
                            Column::make('updated_at')->heading('Updated At'),
                        ])->ignoreFormatting()
                            ->withFilename(date('Y-m-d') . ' - export-users'),
                    ]),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
