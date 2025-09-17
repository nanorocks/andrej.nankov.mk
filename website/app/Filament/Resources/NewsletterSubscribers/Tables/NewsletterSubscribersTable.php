<?php

namespace App\Filament\Resources\NewsletterSubscribers\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\ExportBulkAction;

class NewsletterSubscribersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                IconColumn::make('subscribed')
                    ->boolean(),
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
                            Column::make('email')->heading('Email'),
                            Column::make('subscribed')->heading('Subscribed'),
                            Column::make('attributes')->heading('Attributes'),
                            Column::make('created_at')->heading('Created At'),
                            Column::make('updated_at')->heading('Updated At'),
                        ])->ignoreFormatting()
                          ->withFilename(date('Y-m-d') . ' - export-newsletter-subscribers'),
                    ]),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
