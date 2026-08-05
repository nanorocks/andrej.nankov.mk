<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        event(new Registered(($user = User::create($validated))));
        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<section class="auth-shell" aria-labelledby="register-title">
    <div class="auth-card">
        <div class="auth-card-header">
            <p class="public-kicker">One account, every purchase</p>
            <h1 id="register-title" class="mt-3 text-3xl font-extrabold tracking-tight text-white">Create your account</h1>
            <p class="mt-3 leading-7 text-slate-400">Track orders and keep your digital products available whenever you need them.</p>
        </div>

        <form wire:submit="register" class="space-y-5">
            <div>
                <label for="name" class="auth-label">Full name</label>
                <input wire:model="name" id="name" class="public-form-input mt-2" type="text" name="name" required autofocus autocomplete="name" placeholder="Your name">
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-300" />
            </div>

            <div>
                <label for="email" class="auth-label">Email address</label>
                <input wire:model="email" id="email" class="public-form-input mt-2" type="email" name="email" required autocomplete="username" placeholder="you@example.com">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300" />
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="password" class="auth-label">Password</label>
                    <input wire:model="password" id="password" class="public-form-input mt-2" type="password" name="password" required autocomplete="new-password" placeholder="Create password">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300" />
                </div>

                <div>
                    <label for="password_confirmation" class="auth-label">Confirm password</label>
                    <input wire:model="password_confirmation" id="password_confirmation" class="public-form-input mt-2" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repeat password">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-300" />
                </div>
            </div>

            <p class="text-xs leading-5 text-slate-500">After registering, verify your email before completing a purchase. This protects your order history and downloads.</p>

            <button type="submit" class="public-button-primary w-full" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="register">Create account</span>
                <span wire:loading wire:target="register">Creating account...</span>
            </button>
        </form>

        <p class="mt-7 border-t border-white/10 pt-6 text-center text-sm text-slate-400">
            Already have an account?
            <a href="{{ route('login') }}" class="font-bold text-red-400 hover:text-red-300" wire:navigate>Sign in</a>
        </p>
    </div>
</section>
