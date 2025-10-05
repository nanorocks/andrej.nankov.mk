<?php

namespace App\Filament\Resources\NewsletterLicenses;

use BackedEnum;
use App\Models\License;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\NewsletterLicenses\Pages\EditNewsletterLicense;
use App\Filament\Resources\NewsletterLicenses\Pages\ListNewsletterLicenses;
use App\Filament\Resources\NewsletterLicenses\Pages\CreateNewsletterLicense;
use App\Filament\Resources\NewsletterLicenses\Schemas\NewsletterLicenseForm;
use App\Filament\Resources\NewsletterLicenses\Tables\NewsletterLicensesTable;
use App\Filament\Resources\NewsletterLicenses\Schemas\NewsletterLicenseInfolist;


class NewsletterLicenseResource extends Resource
{
    protected static ?string $model = License::class;

    // Icon for software licenses section in navigation
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedKey;

    protected static ?string $recordTitleAttribute = 'license_key';

    public static function form(Schema $schema): Schema
    {
        return NewsletterLicenseForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return NewsletterLicenseInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NewsletterLicensesTable::configure($table);
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
            'index' => ListNewsletterLicenses::route('/'),
            'create' => CreateNewsletterLicense::route('/create'),
            'edit' => EditNewsletterLicense::route('/{record}/edit'),
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
        return 'Settings';
    }
}
