<?php

namespace App\Filament\Resources\NewsletterLicenses\Pages;

use App\Filament\Resources\NewsletterLicenses\NewsletterLicenseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNewsletterLicenses extends ListRecords
{
    protected static string $resource = NewsletterLicenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
