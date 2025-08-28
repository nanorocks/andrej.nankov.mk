<?php

namespace App\Filament\Resources\PluginDatabaseNewsletterLicenses\Pages;

use App\Filament\Resources\PluginDatabaseNewsletterLicenses\PluginDatabaseNewsletterLicenseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPluginDatabaseNewsletterLicenses extends ListRecords
{
    protected static string $resource = PluginDatabaseNewsletterLicenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
