<?php

namespace App\Filament\Resources\NewsletterLicenses;

use App\Filament\Resources\NewsletterLicenses\Pages\CreateNewsletterLicense;
use App\Filament\Resources\NewsletterLicenses\Pages\EditNewsletterLicense;
use App\Filament\Resources\NewsletterLicenses\Pages\ListNewsletterLicenses;
use App\Filament\Resources\NewsletterLicenses\Schemas\NewsletterLicenseForm;
use App\Filament\Resources\NewsletterLicenses\Schemas\NewsletterLicenseInfolist;
use App\Filament\Resources\NewsletterLicenses\Tables\NewsletterLicensesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Nanorocks\LicenseManager\Models\License;

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

    public static function viewSchema(Schema $schema): Schema
    {

        return NewsletterLicenseInfolist::configure($schema)
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
        return 'Portfolio Website';
    }
}
