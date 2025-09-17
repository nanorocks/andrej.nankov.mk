<?php

namespace App\Filament\Resources\PluginDatabaseNewsletterLicenses\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use pxlrbt\FilamentExcel\Columns\Column;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\ForceDeleteBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\ExportBulkAction;

class PluginDatabaseNewsletterLicensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('license_key')->searchable()->sortable(),
                TextColumn::make('assigned_to')->searchable()->sortable(),
                IconColumn::make('active')->boolean(true),
                TextColumn::make('expires_at')->dateTime('M d, Y H:i'),
                TextColumn::make('created_at')->dateTime('M d, Y H:i'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()->exports([
                        ExcelExport::make()->withColumns([
                            Column::make('license_key')->heading('License Key'),
                            Column::make('assigned_to')->heading('Assigned To'),
                            Column::make('active')->heading('Active'),
                            Column::make('expires_at')->heading('Expires At'),
                            Column::make('metadata')->heading('Metadata'),
                            Column::make('created_at')->heading('Created At'),
                            Column::make('updated_at')->heading('Updated At'),
                        ])->ignoreFormatting()
                          ->withFilename(date('Y-m-d') . ' - export-licenses'),
                    ]),
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
