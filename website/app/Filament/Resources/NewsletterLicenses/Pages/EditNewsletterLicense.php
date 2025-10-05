<?php

namespace App\Filament\Resources\NewsletterLicenses\Pages;

use App\Filament\Resources\NewsletterLicenses\NewsletterLicenseResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditNewsletterLicense extends EditRecord
{
    protected static string $resource = NewsletterLicenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
