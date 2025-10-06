<?php

namespace App\Filament\Resources\VehicleAttributes;

use BackedEnum;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use App\Models\VehicleAttribute;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use App\Filament\Resources\VehicleAttributes\Pages\EditVehicleAttribute;
use App\Filament\Resources\VehicleAttributes\Pages\ListVehicleAttributes;
use App\Filament\Resources\VehicleAttributes\Pages\CreateVehicleAttribute;
use App\Filament\Resources\VehicleAttributes\Schemas\VehicleAttributeForm;
use App\Filament\Resources\VehicleAttributes\Tables\VehicleAttributesTable;

class VehicleAttributeResource extends Resource
{
    protected static ?string $model = VehicleAttribute::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::Pipette;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return VehicleAttributeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VehicleAttributesTable::configure($table);
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
            'index' => ListVehicleAttributes::route('/'),
            'create' => CreateVehicleAttribute::route('/create'),
            'edit' => EditVehicleAttribute::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Car Management';
    }
}
