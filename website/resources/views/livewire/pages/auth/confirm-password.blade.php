<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $password = '';

    /**
     * Confirm the current user's password.
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<section class="auth-shell" aria-labelledby="confirm-password-title">
    <div class="auth-card">
        <div class="auth-card-header">
            <p class="public-kicker">Secure area</p>
            <h1 id="confirm-password-title" class="mt-3 text-3xl font-extrabold tracking-tight text-white">Confirm your password</h1>
            <p class="mt-3 leading-7 text-slate-400">Please confirm your password before continuing.</p>
        </div>

        <form wire:submit="confirmPassword" class="space-y-5">
            <div>
                <label for="password" class="auth-label">Password</label>
                <input wire:model="password" id="password" class="public-form-input mt-2" type="password" name="password" required autofocus autocomplete="current-password">
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300" />
            </div>

            <button type="submit" class="public-button-primary w-full" wire:loading.attr="disabled">Confirm and continue</button>
        </form>
    </div>
</section>
