<?php

namespace App\Filament\Resources\NewsletterPages\Pages;

use App\Filament\Resources\NewsletterPages\NewsletterPageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNewsletterPages extends ListRecords
{
    protected static string $resource = NewsletterPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
