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
                                \Filament\Forms\Components\FileUpload::make('profile_image')
                                    ->label('Profile Image')
                                    ->image()
                                    ->directory(fn($get) => "{$get('flag')}/profile_images")
                                    ->disk('public')
                                    ->maxSize(2048),
                                TextInput::make('name')->required(),
                                TextInput::make('title'),
                                MarkdownEditor::make('content')->required()->columnSpanFull(),
                                TextInput::make('cv_url'),
                                Toggle::make('is_published')->required(),
                            ])
                            ->columnSpan([
                                'default' => 12,
                                'lg' => 8,
                            ]),

                        Section::make('SEO')
                            ->schema([
                                Toggle::make('include_seo_in_header')->required(),
                                TextInput::make('seo_title'),
                                TextInput::make('seo_description'),
                                TextInput::make('seo_keywords'),
                                TextInput::make('seo_author'),
                                TextInput::make('seo_robots'),
                            ])
                            ->columnSpan([
                                'default' => 12,
                                'lg' => 4,
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
            ])
            ->components([
                Grid::make()
                    ->schema([
                        Section::make('Main')
                            ->schema([
                                TextInput::make('flag')->required(),
                                FileUpload::make('profile_image')
                                    ->image()
                                    ->imageResizeMode('cover')
                                    ->imageResizeTargetWidth(600)
                                    ->imageResizeTargetHeight(315),
                                TextInput::make('name')->required(),
                                TextInput::make('title'),
                                MarkdownEditor::make('content')->required()->columnSpanFull(),
                                TextInput::make('cv_url'),
                                Toggle::make('is_published')->required(),
                            ])
                            ->columnSpan([
                                'default' => 12, // mobile full width
                                'lg' => 8,      // large screens: 10 columns
                            ]),

                        Section::make('SEO')
                            ->schema([
                                Toggle::make('include_seo_in_header')->required(),
                                TextInput::make('seo_title'),
                                TextInput::make('seo_description'),
                                TextInput::make('seo_keywords'),
                                TextInput::make('seo_author'),
                                TextInput::make('seo_robots'),
                            ])
                            ->columnSpan([
                                'default' => 12,
                                'lg' => 4,
                            ]),

                        Section::make('Open Graph')
                            ->schema([
                                TextInput::make('og_title'),
                                TextInput::make('og_description'),
                                TextInput::make('og_type'),
                                TextInput::make('og_url'),
                                FileUpload::make('og_image')
                                    ->image()
                                    ->imageResizeMode('cover')
                                    ->imageResizeTargetWidth(600)
                                    ->imageResizeTargetHeight(315),
                                FileUpload::make('og_image_alt')
                                    ->image()
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
                                    ->imageResizeMode('cover')
                                    ->imageResizeTargetWidth(600)
                                    ->imageResizeTargetHeight(315),
                                FileUpload::make('twitter_image_alt')
                                    ->image()
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
                        'default' => 1, // mobile: 1 column
                        'lg' => 12,     // large screens: 12 columns
                    ])
                    ->columnSpanFull(),
            ])
            ->components([
                Grid::make()
                    ->schema([
                        Section::make('Main')
                            ->schema([
                                TextInput::make('flag')->required(),
                                \Filament\Forms\Components\FileUpload::make('profile_image')
                                    ->label('Profile Image')
                                    ->image()
                                    ->directory(fn($get) => "{$get('flag')}/profile_images")
                                    ->disk('public')
                                    ->maxSize(2048),
                                TextInput::make('name')->required(),
                                TextInput::make('title'),
                                MarkdownEditor::make('content')->required()->columnSpanFull(),
                                TextInput::make('cv_url'),
                                Toggle::make('is_published')->required(),
                            ])
                            ->columnSpan([
                                'default' => 12,
                                'lg' => 8,
                            ]),

                        Section::make('SEO')
                            ->schema([
                                Toggle::make('include_seo_in_header')->required(),
                                TextInput::make('seo_title'),
                                TextInput::make('seo_description'),
                                TextInput::make('seo_keywords'),
                                TextInput::make('seo_author'),
                                TextInput::make('seo_robots'),
                            ])
                            ->columnSpan([
                                'default' => 12,
                                'lg' => 4,
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
                                    ->label('OG Image'),
                                FileUpload::make('og_image_alt')
                                    ->image()
                                    ->disk('public')
                                    ->label('OG Image Alt'),
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
                                    ->label('Twitter Image'),
                                FileUpload::make('twitter_image_alt')
                                    ->image()
                                    ->disk('public')
                                    ->label('Twitter Image Alt'),
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
            ])
            ->components([
                Grid::make()
                    ->schema([
                        Section::make('Main')
                            ->schema([
                                TextInput::make('flag')->required(),
                                FileUpload::make('profile_image')->image(),
                                TextInput::make('name')->required(),
                                TextInput::make('title'),
                                MarkdownEditor::make('content')->required()->columnSpanFull(),
                                TextInput::make('cv_url'),
                                Toggle::make('is_published')->required(),
                            ])
                            ->columnSpan([
                                'default' => 12, // mobile full width
                                'lg' => 8,      // large screens: 10 columns
                            ]),

                        Section::make('SEO')
                            ->schema([
                                Toggle::make('include_seo_in_header')->required(),
                                TextInput::make('seo_title'),
                                TextInput::make('seo_description'),
                                TextInput::make('seo_keywords'),
                                TextInput::make('seo_author'),
                                TextInput::make('seo_robots'),
                            ])
                            ->columnSpan([
                                'default' => 12,
                                'lg' => 4,
                            ]),

                        Section::make('Open Graph')
                            ->schema([
                                TextInput::make('og_title'),
                                TextInput::make('og_description'),
                                TextInput::make('og_type'),
                                TextInput::make('og_url'),
                                FileUpload::make('og_image')->image(),
                                FileUpload::make('og_image_alt')->image(),
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
                                FileUpload::make('twitter_image')->image(),
                                FileUpload::make('twitter_image_alt')->image(),
                                TextInput::make('twitter_creator'),
                            ])
                            ->columnSpan([
                                'default' => 12,
                                'lg' => 6,
                            ]),
                    ])
                    ->columns([
                        'default' => 1, // mobile: 1 column
                        'lg' => 12,     // large screens: 12 columns
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
