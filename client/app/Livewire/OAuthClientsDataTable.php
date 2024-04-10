<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Client;

class OAuthClientsDataTable extends DataTableComponent
{
    protected $model = Client::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Name", "name")
                ->sortable(),

            Column::make("Client Id", "id")
                ->sortable(),

            Column::make("Client Secret", "secret")
                ->sortable(),

            Column::make("User ID", "user_id")
                ->sortable(),

            Column::make("Redirect", "redirect")
                ->sortable(),

            Column::make("Personal Access Client", "personal_access_client")
                ->sortable(),

            Column::make("Password Client", "password_client")
                ->sortable(),

            Column::make("Revoked", "revoked")
                ->sortable(),

            Column::make("Created at", "created_at")
                ->sortable(),
                
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}