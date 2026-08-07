<?php

namespace App\Filament\Resources\Products\Tables;

use App\Models\Product;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->description(fn (Product $record): string => $record->slug)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Product::TYPE_BOARD_GAME => 'Board game',
                        Product::TYPE_EBOOK => 'E-book',
                        default => $state,
                    }),
                TextColumn::make('price')
                    ->label('Price')
                    ->formatStateUsing(fn (int $state, Product $record): string => number_format($state / 100, 2).' '.$record->currency)
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Visible')
                    ->boolean(),
                IconColumn::make('is_coming_soon')
                    ->label('Coming soon')
                    ->boolean(),
                TextColumn::make('order_items_count')
                    ->label('Sales')
                    ->counts('orderItems')
                    ->sortable(),
                TextColumn::make('paddle_price_id')
                    ->label('Paddle price')
                    ->copyable()
                    ->placeholder('Not connected')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        Product::TYPE_BOARD_GAME => 'Board game',
                        Product::TYPE_EBOOK => 'E-book',
                    ]),
                TernaryFilter::make('is_active')->label('Visible in shop'),
                TernaryFilter::make('is_coming_soon')->label('Coming soon'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order');
    }
}
