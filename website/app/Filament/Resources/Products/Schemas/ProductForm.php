<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Product details')
                    ->description('The customer-facing information displayed in the shop.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),
                                TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->helperText('Used in shop and download URLs.'),
                                Select::make('type')
                                    ->options([
                                        Product::TYPE_BOARD_GAME => 'Board game',
                                        Product::TYPE_EBOOK => 'E-book',
                                    ])
                                    ->required()
                                    ->native(false)
                                    ->live(),
                                TextInput::make('sort_order')
                                    ->label('Display order')
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0)
                                    ->required(),
                                Textarea::make('description')
                                    ->required()
                                    ->rows(5)
                                    ->maxLength(5000)
                                    ->columnSpanFull(),
                            ]),
                    ]),
                Section::make('Pricing and Paddle')
                    ->description('Configure the one-time price and connect it to a Paddle price.')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('price')
                                    ->label('Price')
                                    ->numeric()
                                    ->minValue(0)
                                    ->step(0.01)
                                    ->required()
                                    ->formatStateUsing(fn (?int $state): ?string => $state === null ? null : number_format($state / 100, 2, '.', ''))
                                    ->dehydrateStateUsing(fn (mixed $state): int => (int) round(((float) $state) * 100))
                                    ->helperText('Enter the customer-facing amount, for example 19.00.'),
                                TextInput::make('currency')
                                    ->required()
                                    ->default('EUR')
                                    ->minLength(3)
                                    ->maxLength(3)
                                    ->dehydrateStateUsing(fn (?string $state): string => strtoupper($state ?? 'EUR')),
                                TextInput::make('paddle_price_id')
                                    ->label('Paddle price ID')
                                    ->placeholder('pri_...')
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->helperText('Required before a product can be purchased.'),
                            ]),
                    ]),
                Section::make('Digital delivery')
                    ->description('E-books are stored privately and only served to customers with completed orders.')
                    ->schema([
                        FileUpload::make('download_path')
                            ->label('E-book PDF')
                            ->disk('local')
                            ->directory('shop')
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(51200)
                            ->downloadable()
                            ->visible(fn (Get $get): bool => $get('type') === Product::TYPE_EBOOK)
                            ->helperText('PDF only, up to 50 MB.'),
                    ])
                    ->visible(fn (Get $get): bool => $get('type') === Product::TYPE_EBOOK),
                Section::make('Availability')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Toggle::make('is_active')
                                    ->label('Visible in shop')
                                    ->default(true)
                                    ->helperText('Inactive products are hidden from customers.'),
                                Toggle::make('is_coming_soon')
                                    ->label('Coming soon')
                                    ->default(true)
                                    ->helperText('Coming-soon products are visible but cannot be purchased.'),
                            ]),
                    ]),
            ]);
    }
}
