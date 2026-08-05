<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<section class="auth-shell" aria-labelledby="sign-in-title">
    <div class="auth-card">
        <div class="auth-card-header">
            <p class="public-kicker">Your library awaits</p>
            <h1 id="sign-in-title" class="mt-3 text-3xl font-extrabold tracking-tight text-white">Welcome back</h1>
            <p class="mt-3 leading-7 text-slate-400">Sign in to review orders and download your purchased e-books.</p>
        </div>

        <x-auth-session-status class="public-alert-success mb-6" :status="session('status')" />

        <form wire:submit="login" class="space-y-5">
            <div>
                <label for="email" class="auth-label">Email address</label>
                <input wire:model="form.email" id="email" class="public-form-input mt-2" type="email" name="email" required autofocus autocomplete="username" placeholder="you@example.com">
                <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-red-300" />
            </div>

            <div>
                <div class="flex items-center justify-between gap-4">
                    <label for="password" class="auth-label">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="public-text-link text-xs" wire:navigate>Forgot password?</a>
                    @endif
                </div>
                <input wire:model="form.password" id="password" class="public-form-input mt-2" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password">
                <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-red-300" />
            </div>

            <label for="remember" class="flex cursor-pointer items-center gap-3 text-sm text-slate-300">
                <input wire:model="form.remember" id="remember" type="checkbox" name="remember" class="rounded border-white/20 bg-black/20 text-red-500 focus:ring-red-500">
                <span>Keep me signed in</span>
            </label>

            <button type="submit" class="public-button-primary w-full" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="login">Sign in</span>
                <span wire:loading wire:target="login">Signing in...</span>
            </button>
        </form>

        <p class="mt-7 border-t border-white/10 pt-6 text-center text-sm text-slate-400">
            New to the shop?
            <a href="{{ route('register') }}" class="font-bold text-red-400 hover:text-red-300" wire:navigate>Create your account</a>
        </p>
    </div>
</section>
