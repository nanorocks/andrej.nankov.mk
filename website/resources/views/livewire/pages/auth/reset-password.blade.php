<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset($this->only('email', 'password', 'password_confirmation', 'token'), function ($user) {
            $user
                ->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])
                ->save();

            event(new PasswordReset($user));
        });

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<section class="auth-shell" aria-labelledby="new-password-title">
    <div class="auth-card">
        <div class="auth-card-header">
            <p class="public-kicker">Account recovery</p>
            <h1 id="new-password-title" class="mt-3 text-3xl font-extrabold tracking-tight text-white">Choose a new password</h1>
            <p class="mt-3 leading-7 text-slate-400">Use a strong, unique password to protect your orders and downloads.</p>
        </div>

        <form wire:submit="resetPassword" class="space-y-5">
            <div>
                <label for="email" class="auth-label">Email address</label>
                <input wire:model="email" id="email" class="public-form-input mt-2" type="email" name="email" required autofocus autocomplete="username">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300" />
            </div>

            <div>
                <label for="password" class="auth-label">New password</label>
                <input wire:model="password" id="password" class="public-form-input mt-2" type="password" name="password" required autocomplete="new-password">
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300" />
            </div>

            <div>
                <label for="password_confirmation" class="auth-label">Confirm new password</label>
                <input wire:model="password_confirmation" id="password_confirmation" class="public-form-input mt-2" type="password" name="password_confirmation" required autocomplete="new-password">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-300" />
            </div>

            <button type="submit" class="public-button-primary w-full" wire:loading.attr="disabled">Reset password</button>
        </form>
    </div>
</section>
