<?php

namespace App\Livewire;

use App\Models\User;
use App\Repositories\PassportClientRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ClientCredentialsGrant extends Component
{
    public Collection $userClients;

    public PassportClientRepository $clientRepository;

    public User $authUser;

    public string $msg = '';

    public bool $archiveRevoked = true;

    #[Validate('required|max:20')]
    public ?string $createClient = '';

    public function __construct()
    {
        $this->authUser = Auth::user();
    }

    #[On('load-clients')]
    public function boot()
    {
        $clientRepository = app(PassportClientRepository::class);

        $uClient = $clientRepository->forUser($this->authUser->id);

        if (!$this->archiveRevoked) {
            $uClient = $clientRepository->forUser($this->authUser->id)->where('archive_revoked', $this->archiveRevoked);
        }

        $this->userClients = $uClient;

        session()->flash('msg', $this->msg);
    }

    public function revokeClient(array $client)
    {
        $clientId = $client['id'];

        $clientRepository = app(PassportClientRepository::class);

        $client = $clientRepository->findForUser($clientId, $this->authUser->id);

        $clientRepository->delete($client);

        $this->dispatch('load-clients');

        $this->msg = 'The client with name: ' . $client['name'] . ' has been revoked!';
    }

    public function archiveRevokedAction()
    {
        $clientRepository = app(PassportClientRepository::class);

        $clientRepository->updateAllByAttribute($this->authUser->id, 'archive_revoked', true);

        $this->archiveRevoked = !$this->archiveRevoked;

        $this->dispatch('load-clients');
    }

    public function createClientAction()
    {
        $this->validate();

        $exec = Artisan::call(
            sprintf(
                'app:custom-client-credentials-grant --userId=%s --appName="%s"',
                $this->authUser->id,
                $this->createClient
            )
        );

        $this->dispatch('load-clients');

        $this->msg = 'New client with name:' . $this->createClient . ' has been created!';

        $this->reset('createClient');
    }

    public function render()
    {
        return view('livewire.client-credentials-grant');
    }
}
