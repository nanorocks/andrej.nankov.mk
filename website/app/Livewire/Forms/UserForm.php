<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Form;

class UserForm extends Form
{
    public ?User $userModel;
    
    public $name = '';
    public $avatar = '';
    public $email = '';
    public $phone_number = '';
    public $address = '';
    public $website_url = '';
    public $medium_url = '';
    public $social_media = '';
    public $role = '';
    public $bio = '';

    public function rules(): array
    {
        return [
			'name' => 'required|string',
			'avatar' => 'string',
			'email' => 'required|string',
			'phone_number' => 'string',
			'address' => 'string',
			'website_url' => 'string',
			'medium_url' => 'string',
			'role' => 'required|string',
			'bio' => 'string',
        ];
    }

    public function setUserModel(User $userModel): void
    {
        $this->userModel = $userModel;
        
        $this->name = $this->userModel->name;
        $this->avatar = $this->userModel->avatar;
        $this->email = $this->userModel->email;
        $this->phone_number = $this->userModel->phone_number;
        $this->address = $this->userModel->address;
        $this->website_url = $this->userModel->website_url;
        $this->medium_url = $this->userModel->medium_url;
        $this->social_media = $this->userModel->social_media;
        $this->role = $this->userModel->role;
        $this->bio = $this->userModel->bio;
    }

    public function store(): void
    {
        $this->userModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->userModel->update($this->validate());

        $this->reset();
    }
}
