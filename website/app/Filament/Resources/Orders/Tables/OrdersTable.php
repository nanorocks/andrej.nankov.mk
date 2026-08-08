<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Models\Order;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Order')->formatStateUsing(fn (int $state): string => '#'.$state)->sortable(),
                TextColumn::make('user.name')->label('Customer')->description(fn (Order $record): string => $record->user->email)->searchable(),
                TextColumn::make('items.product_name')->label('Products')->bulleted()->limitList(3),
                TextColumn::make('total')
                    ->formatStateUsing(fn (int $state, Order $record): string => number_format($state / 100, 2).' '.$record->currency)
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Payment')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Order::STATUS_COMPLETED => 'Paid',
                        Order::STATUS_CANCELLED => 'Cancelled',
                        default => 'Payment pending',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        Order::STATUS_COMPLETED => 'success',
                        Order::STATUS_CANCELLED => 'gray',
                        default => 'warning',
                    }),
                IconColumn::make('requires_shipping')->label('Delivery')->boolean(),
                TextColumn::make('delivery_status')
                    ->label('Delivery status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => Order::deliveryStatusOptions()[$state] ?? 'Digital order')
                    ->color(fn (?string $state): string => match ($state) {
                        Order::DELIVERY_DELIVERED => 'success',
                        Order::DELIVERY_SHIPPED => 'info',
                        Order::DELIVERY_READY_TO_SHIP => 'warning',
                        Order::DELIVERY_ADDRESS_REQUIRED => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('shipping_name')->label('Recipient')->placeholder('—')->searchable(),
                TextColumn::make('shipping_city')->label('City')->placeholder('—')->searchable(),
                TextColumn::make('created_at')->label('Ordered')->dateTime()->sortable(),
            ])
            ->filters([
                TernaryFilter::make('requires_shipping')->label('Physical delivery'),
                SelectFilter::make('status')->label('Payment status')->options([
                    Order::STATUS_PENDING => 'Pending',
                    Order::STATUS_COMPLETED => 'Completed',
                    Order::STATUS_CANCELLED => 'Cancelled',
                ]),
                SelectFilter::make('delivery_status')->options(Order::deliveryStatusOptions()),
            ])
            ->recordActions([
                EditAction::make()->label('Manage'),
                DeleteAction::make()
                    ->modalHeading('Delete order')
                    ->modalDescription('This permanently deletes the order and its items. Any digital download access granted by this order will also be removed.')
                    ->successNotificationTitle('Order deleted'),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
