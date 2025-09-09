<?php

namespace App\Filament\Resources\NewsletterPages;

use App\Filament\Resources\NewsletterPages\Pages\CreateNewsletterPage;
use App\Filament\Resources\NewsletterPages\Pages\EditNewsletterPage;
use App\Filament\Resources\NewsletterPages\Pages\ListNewsletterPages;
use App\Filament\Resources\NewsletterPages\Schemas\NewsletterPageForm;
use App\Filament\Resources\NewsletterPages\Tables\NewsletterPagesTable;
use App\Models\NewsletterPage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class NewsletterPageResource extends Resource
{
    protected static ?string $model = NewsletterPage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return NewsletterPageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NewsletterPagesTable::configure($table);
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
            'index' => ListNewsletterPages::route('/'),
            'create' => CreateNewsletterPage::route('/create'),
            'edit' => EditNewsletterPage::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Portfolio Website';
    }
}
