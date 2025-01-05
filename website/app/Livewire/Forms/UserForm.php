<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
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
            'email' => 'required|email|max:255',
            'phone_number' => 'string',
            'address' => 'string',
            'website_url' => 'string',
            'medium_url' => 'string',
            'social_media' => 'string',
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
        $this->social_media = json_decode($this->userModel->social_media, true);
        $this->role = $this->userModel->role;
        $this->bio = $this->userModel->bio;
    }

    public function store(): void
    {
        $data = $this->validate();
        $data['social_media'] = json_encode($data['social_media']);

        // Generate a random password if not provided
        $data['password'] = Hash::make($data['password'] ?? 'secret'); // Set a temporary password

        $user = User::create($data);

        // Send email to set password
        Password::sendResetLink(['email' => $user->email]);

        $this->reset();
    }

    public function update(): void
    {
        $data = $this->validate();
        $data['social_media'] = json_encode($data['social_media']);

        $this->userModel->update($data);

        $this->reset();
    }
}
