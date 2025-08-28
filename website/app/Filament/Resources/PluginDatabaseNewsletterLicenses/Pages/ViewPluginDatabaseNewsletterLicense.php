<?php

namespace App\Filament\Resources\PluginDatabaseNewsletterLicenses\Pages;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\PluginDatabaseNewsletterLicenses\PluginDatabaseNewsletterLicenseResource;

class ViewPluginDatabaseNewsletterLicense extends ViewRecord
{
    protected static string $resource = PluginDatabaseNewsletterLicenseResource::class;

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
