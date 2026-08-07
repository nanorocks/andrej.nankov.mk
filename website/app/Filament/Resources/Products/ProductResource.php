<?php

namespace App\Filament\Resources\Products;

use App\Filament\Resources\Products\Pages\CreateProduct;
use App\Filament\Resources\Products\Pages\EditProduct;
use App\Filament\Resources\Products\Pages\ListProducts;
use App\Filament\Resources\Products\Schemas\ProductForm;
use App\Filament\Resources\Products\Tables\ProductsTable;
use App\Models\Product;
use BackedEnum;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingBag;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Products';

    public static function form(Schema $schema): Schema
    {
        return ProductForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Store';
    }

    public static function canViewAny(): bool
    {
        return static::ownerCanAccessPanel();
    }

    public static function canCreate(): bool
    {
        return static::ownerCanAccessPanel();
    }

    public static function canView(Model $record): bool
    {
        return static::ownerCanAccessPanel();
    }

    public static function canEdit(Model $record): bool
    {
        return static::ownerCanAccessPanel();
    }

    public static function canDelete(Model $record): bool
    {
        return static::ownerCanAccessPanel()
            && $record instanceof Product
            && ! $record->orderItems()->exists();
    }

    public static function canReorder(): bool
    {
        return static::ownerCanAccessPanel();
    }

    public static function getAuthorizationResponse(string $action, ?Model $record = null): Response
    {
        $allowed = static::ownerCanAccessPanel();

        if ($action === 'delete' && $record instanceof Product) {
            $allowed = $allowed && ! $record->orderItems()->exists();
        }

        return $allowed
            ? Response::allow()
            : Response::deny('You are not authorized to manage store products.');
    }

    private static function ownerCanAccessPanel(): bool
    {
        return auth()->check()
            && auth()->user()->canAccessPanel(Filament::getPanel('admin'));
    }
}
