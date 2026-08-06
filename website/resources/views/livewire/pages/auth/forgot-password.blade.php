<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink($this->only('email'));

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<section class="auth-shell" aria-labelledby="forgot-password-title">
    <div class="auth-card">
        <div class="auth-card-header">
            <p class="public-kicker">Account recovery</p>
            <h1 id="forgot-password-title" class="mt-3 text-3xl font-extrabold tracking-tight text-white">Reset your password</h1>
            <p class="mt-3 leading-7 text-slate-400">Enter your account email and we’ll send you a secure reset link.</p>
        </div>

        <x-auth-session-status class="public-alert-success mb-6" :status="session('status')" />

        <form wire:submit="sendPasswordResetLink" class="space-y-5">
            <div>
                <label for="email" class="auth-label">Email address</label>
                <input wire:model="email" id="email" class="public-form-input mt-2" type="email" name="email" required autofocus autocomplete="username" placeholder="you@example.com">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300" />
            </div>

            <button type="submit" class="public-button-primary w-full" wire:loading.attr="disabled">Email reset link</button>
        </form>

        <p class="mt-7 border-t border-white/10 pt-6 text-center text-sm text-slate-400">
            Remembered it? <a href="{{ route('login') }}" class="font-bold text-red-400 hover:text-red-300" wire:navigate>Return to sign in</a>
        </p>
    </div>
</section>
