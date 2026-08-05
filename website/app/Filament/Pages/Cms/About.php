<?php

namespace App\Filament\Pages\Cms;

use App\Filament\Resources\Pages\Schemas\PageForm;
use App\Models\Page;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page as FilamentPage;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

/**
 * @property-read Schema $form
 */
class About extends FilamentPage
{
    protected const FLAG = 'about';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInformationCircle;
    protected static string|UnitEnum|null $navigationGroup = 'Portfolio Website';
    protected static ?int $navigationSort = 2;
    protected static ?string $title = 'About';
    protected static ?string $slug = 'about';

    protected string $view = 'filament.pages.cms-edit';

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->getRecord()->attributesToArray());
    }

    public function getRecord(): Page
    {
        return Page::firstOrCreate(['flag' => static::FLAG], ['name' => static::$title]);
    }

    public function form(Schema $schema): Schema
    {
        return PageForm::configure($schema)
            ->model($this->getRecord())
            ->operation('edit')
            ->statePath('data');
    }

    public function save(): void
    {
        $this->getRecord()->update($this->form->getState());

        Notification::make()
            ->title(static::$title . ' saved')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save')
                ->submit('save'),
        ];
    }
}
