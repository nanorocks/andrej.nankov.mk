<?php

namespace App\Filament\Resources\NewsletterLicenses\Pages;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\NewsletterLicenses\NewsletterLicenseResource;

class ViewNewsletterLicense extends ViewRecord
{
    protected static string $resource = NewsletterLicenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('deactivate')
                ->label('Deactivate License')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->active = false;
                    $this->record->save();

                    $this->notify('success', 'License has been deactivated.');
                }),
        ];
    }

    protected function getFormSchema(): array
    {
        return $this->getResource()::viewSchema(app(\Filament\Schemas\Schema::class))->getFields();
    }
}
