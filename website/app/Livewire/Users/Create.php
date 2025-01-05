<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Livewire\Component;

class Create extends Component
{

    use WithFileUploads;

    public UserForm $form;

    public $rolesOptions = [
        'admin' => 'Admin',
        'editor' => 'Editor',
        'user' => 'User',
    ];

    public function mount(User $user)
    {
        $this->form->setUserModel($user);
    }

    public function save()
    {
        // Handle file upload
        if ($this->form->avatar && !is_string($this->form->avatar)) {
            $this->form->avatar = $this->form->avatar->store('avatars');
        }

        $this->form->store();

        return $this->redirectRoute('users.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.user.create');
    }
}