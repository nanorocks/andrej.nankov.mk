<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->schema([
                        Section::make('Main')
                            ->schema([
                                TextInput::make('flag')->required(),
                                FileUpload::make('profile_image')
                                    ->image()
                                    ->disk('public')
                                    ->directory("pages")
                                    ->label('Profile Image')
                                    ->maxSize(2048),
                                TextInput::make('name')->required(),
                                TextInput::make('title'),
                                TextInput::make('role'),
                                TextInput::make('headline'),
                                Textarea::make('intro'),
                                MarkdownEditor::make('content')->columnSpanFull(),
                                TextInput::make('cv_url'),
                                Toggle::make('is_published')->required(),

                            ])->columnSpan([
                                'default' => 12,
                                'lg' => 12,
                            ]),

                        Section::make('SEO')
                            ->schema([
                                Grid::make()
                                    ->columns(3)
                                    ->schema([
                                        Toggle::make('include_seo_in_header')->required(),
                                        TextInput::make('seo_title'),
                                        TextInput::make('seo_description'),
                                        TextInput::make('seo_keywords'),
                                        TextInput::make('seo_author'),
                                        TextInput::make('seo_robots'),
                                    ]),
                            ])
                            ->columnSpan([
                                'default' => 12,
                                'lg' => 12,
                            ]),

                        Section::make('Open Graph')
                            ->schema([
                                TextInput::make('og_title'),
                                TextInput::make('og_description'),
                                TextInput::make('og_type'),
                                TextInput::make('og_url'),
                                FileUpload::make('og_image')
                                    ->image()
                                    ->disk('public')
                                    ->label('OG Image')
                                    ->imageResizeMode('cover')
                                    ->imageResizeTargetWidth(600)
                                    ->imageResizeTargetHeight(315),
                                FileUpload::make('og_image_alt')
                                    ->image()
                                    ->disk('public')
                                    ->label('OG Image Alt')
                                    ->imageResizeMode('cover')
                                    ->imageResizeTargetWidth(600)
                                    ->imageResizeTargetHeight(315),
                                TextInput::make('og_site_name'),
                            ])
                            ->columnSpan([
                                'default' => 12,
                                'lg' => 6,
                            ]),

                        Section::make('Twitter')
                            ->schema([
                                TextInput::make('twitter_card'),
                                TextInput::make('twitter_title'),
                                TextInput::make('twitter_description'),
                                FileUpload::make('twitter_image')
                                    ->image()
                                    ->disk('public')
                                    ->label('Twitter Image')
                                    ->imageResizeMode('cover')
                                    ->imageResizeTargetWidth(600)
                                    ->imageResizeTargetHeight(315),
                                FileUpload::make('twitter_image_alt')
                                    ->image()
                                    ->disk('public')
                                    ->label('Twitter Image Alt')
                                    ->imageResizeMode('cover')
                                    ->imageResizeTargetWidth(600)
                                    ->imageResizeTargetHeight(315),
                                TextInput::make('twitter_creator'),
                            ])
                            ->columnSpan([
                                'default' => 12,
                                'lg' => 6,
                            ]),
                    ])
                    ->columns([
                        'default' => 1,
                        'lg' => 12,
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
