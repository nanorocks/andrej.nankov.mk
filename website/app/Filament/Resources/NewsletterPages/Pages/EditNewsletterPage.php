<?php

namespace App\Filament\Resources\NewsletterPages\Pages;

use App\Filament\Resources\NewsletterPages\NewsletterPageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNewsletterPage extends EditRecord
{
    protected static string $resource = NewsletterPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
