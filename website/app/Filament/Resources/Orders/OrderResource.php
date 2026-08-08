<?php

namespace App\Filament\Resources\Orders;

use App\Filament\Resources\Orders\Pages\EditOrder;
use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Filament\Resources\Orders\Schemas\OrderForm;
use App\Filament\Resources\Orders\Tables\OrdersTable;
use App\Models\Order;
use BackedEnum;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'Orders & delivery';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return OrderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrdersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Store';
    }

    public static function getNavigationBadge(): ?string
    {
        $count = Order::query()
            ->where('requires_shipping', true)
            ->whereIn('delivery_status', [
                Order::DELIVERY_ADDRESS_REQUIRED,
                Order::DELIVERY_READY_TO_SHIP,
                Order::DELIVERY_PROCESSING,
                Order::DELIVERY_SHIPPED,
            ])
            ->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getAuthorizationResponse(string $action, ?Model $record = null): Response
    {
        $owner = auth()->check()
            && auth()->user()->canAccessPanel(Filament::getPanel('admin'));

        $allowed = $owner && ! in_array($action, ['create', 'deleteAny', 'forceDelete', 'forceDeleteAny', 'replicate'], true);

        return $allowed
            ? Response::allow()
            : Response::deny('You are not authorized to manage orders.');
    }
}
