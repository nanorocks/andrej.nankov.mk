<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Order;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Order')
                ->schema([
                    Grid::make(3)->schema([
                        TextInput::make('id')->label('Order number')->disabled(),
                        TextInput::make('user.name')->label('Customer')->disabled(),
                        TextInput::make('user.email')->label('Email')->disabled(),
                        TextInput::make('status')->label('Payment status')->disabled(),
                        TextInput::make('paddle_transaction_id')->label('Paddle transaction')->disabled(),
                        TextInput::make('completed_at')->label('Paid at')->disabled(),
                    ]),
                ]),
            Section::make('Delivery workflow')
                ->description('Update this marker as the physical order moves through fulfilment.')
                ->schema([
                    Select::make('delivery_status')
                        ->options(Order::deliveryStatusOptions())
                        ->required()
                        ->native(false),
                    Grid::make(2)->schema([
                        TextInput::make('shipped_at')->label('Shipped at')->disabled(),
                        TextInput::make('delivered_at')->label('Delivered at')->disabled(),
                    ]),
                ])
                ->visible(fn (?Order $record): bool => (bool) $record?->requires_shipping),
            Section::make('Delivery address')
                ->description('Physical products are delivered only within North Macedonia.')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('shipping_name')->label('Recipient')->required()->maxLength(255),
                        TextInput::make('shipping_phone')->label('Phone')->required()->maxLength(40),
                        TextInput::make('shipping_address_line_1')->label('Address')->required()->maxLength(255)->columnSpanFull(),
                        TextInput::make('shipping_address_line_2')->label('Additional address details')->maxLength(255)->columnSpanFull(),
                        TextInput::make('shipping_city')->label('City')->required()->maxLength(120),
                        TextInput::make('shipping_postal_code')->label('Postal code')->required()->maxLength(20),
                        TextInput::make('shipping_country')
                            ->label('Country code')
                            ->required()
                            ->default('MK')
                            ->in(['MK'])
                            ->helperText('North Macedonia only.'),
                    ]),
                ])
                ->visible(fn (?Order $record): bool => (bool) $record?->requires_shipping),
        ]);
    }
}
