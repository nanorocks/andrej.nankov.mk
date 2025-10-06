<?php

namespace App\Filament\Resources\VehicleServices;

use BackedEnum;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use App\Models\VehicleService;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use App\Filament\Resources\VehicleServices\Pages\EditVehicleService;
use App\Filament\Resources\VehicleServices\Pages\ListVehicleServices;
use App\Filament\Resources\VehicleServices\Pages\CreateVehicleService;
use App\Filament\Resources\VehicleServices\Schemas\VehicleServiceForm;
use App\Filament\Resources\VehicleServices\Tables\VehicleServicesTable;

class VehicleServiceResource extends Resource
{
    protected static ?string $model = VehicleService::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::Cog;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return VehicleServiceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VehicleServicesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVehicleServices::route('/'),
            'create' => CreateVehicleService::route('/create'),
            'edit' => EditVehicleService::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Car Management';
    }
}
