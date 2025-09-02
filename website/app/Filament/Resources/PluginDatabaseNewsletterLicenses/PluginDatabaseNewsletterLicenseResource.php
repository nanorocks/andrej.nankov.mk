<?php

namespace App\Filament\Resources\PluginDatabaseNewsletterLicenses;

use App\Filament\Resources\PluginDatabaseNewsletterLicenses\Pages\CreatePluginDatabaseNewsletterLicense;
use App\Filament\Resources\PluginDatabaseNewsletterLicenses\Pages\EditPluginDatabaseNewsletterLicense;
use App\Filament\Resources\PluginDatabaseNewsletterLicenses\Pages\ListPluginDatabaseNewsletterLicenses;
use App\Filament\Resources\PluginDatabaseNewsletterLicenses\Pages\ViewPluginDatabaseNewsletterLicense;
use App\Filament\Resources\PluginDatabaseNewsletterLicenses\Schemas\PluginDatabaseNewsletterLicenseForm;
use App\Filament\Resources\PluginDatabaseNewsletterLicenses\Schemas\PluginDatabaseNewsletterLicenseInfolist;
use App\Filament\Resources\PluginDatabaseNewsletterLicenses\Tables\PluginDatabaseNewsletterLicensesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Nanorocks\LicenseManager\Models\License;

class PluginDatabaseNewsletterLicenseResource extends Resource
{
    protected static ?string $model = License::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'license_key';

    public static function form(Schema $schema): Schema
    {
        return PluginDatabaseNewsletterLicenseForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PluginDatabaseNewsletterLicenseInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PluginDatabaseNewsletterLicensesTable::configure($table);
    }

    public static function viewSchema(Schema $schema): Schema
    {

        return PluginDatabaseNewsletterLicenseInfolist::configure($schema)
            ->disableEditing();
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
            'index' => ListPluginDatabaseNewsletterLicenses::route('/'),
            'create' => CreatePluginDatabaseNewsletterLicense::route('/create'),
            // 'view' => ViewPluginDatabaseNewsletterLicense::route('/{record}'),
            'edit' => EditPluginDatabaseNewsletterLicense::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
