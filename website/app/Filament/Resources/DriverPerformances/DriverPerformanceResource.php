<?php

namespace App\Filament\Resources\DriverPerformances;

use BackedEnum;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use App\Models\DriverPerformance;
use Filament\Support\Icons\Heroicon;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use App\Filament\Resources\DriverPerformances\Pages\EditDriverPerformance;
use App\Filament\Resources\DriverPerformances\Pages\ListDriverPerformances;
use App\Filament\Resources\DriverPerformances\Pages\CreateDriverPerformance;
use App\Filament\Resources\DriverPerformances\Schemas\DriverPerformanceForm;
use App\Filament\Resources\DriverPerformances\Tables\DriverPerformancesTable;

class DriverPerformanceResource extends Resource
{
    protected static ?string $model = DriverPerformance::class;

    protected static string|BackedEnum|null $navigationIcon = LucideIcon::PieChart;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return DriverPerformanceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DriverPerformancesTable::configure($table);
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
            'index' => ListDriverPerformances::route('/'),
            'create' => CreateDriverPerformance::route('/create'),
            'edit' => EditDriverPerformance::route('/{record}/edit'),
        ];
    }


    public static function getNavigationGroup(): ?string
    {
        return 'Car Management';
    }
}
