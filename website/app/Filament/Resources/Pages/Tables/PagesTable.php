<?php

namespace App\Filament\Resources\Pages\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\ExportBulkAction;

class PagesTable
{

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile_image')
                    ->label('Profile Image')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('flag')
                    ->searchable()
                    ->formatStateUsing(fn($state) => strtoupper($state)),
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
                    ExportBulkAction::make()->exports([
                        ExcelExport::make()->withColumns([
                            // add all columns from the model
                            Column::make('flag')->heading('Flag'),
                            Column::make('profile_image')->heading('Profile Image'),
                            Column::make('name')->heading('User Name'),
                            Column::make('title')->heading('Title'),
                            Column::make('role')->heading('Role'),
                            Column::make('headline')->heading('Headline'),
                            Column::make('intro')->heading('Intro'),
                            Column::make('content')->heading('Content'),
                            Column::make('cv_url')->heading('CV URL'),
                            Column::make('is_published')->heading('Is Published'),
                            Column::make('include_seo_in_header')->heading('Include SEO In Header'),
                            Column::make('seo_title')->heading('SEO Title'),
                            Column::make('seo_description')->heading('SEO Description'),
                            Column::make('seo_keywords')->heading('SEO Keywords'),
                            Column::make('seo_author')->heading('SEO Author'),
                            Column::make('seo_robots')->heading('SEO Robots'),
                            Column::make('og_title')->heading('OG Title'),
                            Column::make('og_description')->heading('OG Description'),
                            Column::make('og_type')->heading('OG Type'),
                            Column::make('og_url')->heading('OG URL'),
                            Column::make('og_image')->heading('OG Image'),
                            Column::make('og_image_alt')->heading('OG Image Alt'),
                            Column::make('og_site_name')->heading('OG Site Name'),
                            Column::make('twitter_card')->heading('Twitter Card'),
                            Column::make('twitter_title')->heading('Twitter Title'),
                            Column::make('twitter_description')->heading('Twitter Description'),
                            Column::make('twitter_image')->heading('Twitter Image'),
                            Column::make('twitter_image_alt')->heading('Twitter Image Alt'),
                            Column::make('twitter_creator')->heading('Twitter Creator'),

                        ])->ignoreFormatting()
                            ->withFilename(date('Y-m-d') . ' - export-pages'),
                    ]),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
