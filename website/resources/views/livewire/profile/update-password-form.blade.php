<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component {
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>
<section>
    <header>
        <p class="public-kicker">Security</p>
        <h2 class="mt-2 text-xl font-extrabold text-white">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-2 text-sm leading-6 text-slate-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form wire:submit="updatePassword" class="mt-7 space-y-5">
        <div>
            <label class="block">
                <span class="auth-label">{{ __('Current Password') }}</span>
                <input type="password" wire:model="current_password" id="update_password_current_password"
                    name="current_password" placeholder="Enter current password"
                    class="public-form-input mt-2" autocomplete="current-password" />
                @error('current_password') <span class="mt-2 block text-sm text-red-300">{{ $message }}</span> @enderror
            </label>
        </div>

        <div>
            <label class="block">
                <span class="auth-label">{{ __('New Password') }}</span>
                <input type="password" wire:model="password" id="update_password_password" name="password"
                    placeholder="Enter new password" class="public-form-input mt-2"
                    autocomplete="new-password" />
                @error('password') <span class="mt-2 block text-sm text-red-300">{{ $message }}</span> @enderror
            </label>
        </div>

        <div>
            <label class="block">
                <span class="auth-label">{{ __('Confirm Password') }}</span>
                <input type="password" wire:model="password_confirmation" id="update_password_password_confirmation"
                    name="password_confirmation" placeholder="Confirm new password"
                    class="public-form-input mt-2" autocomplete="new-password" />
                @error('password_confirmation') <span class="mt-2 block text-sm text-red-300">{{ $message }}</span> @enderror
            </label>
        </div>

        <div class="flex items-center gap-4 pt-1">
            <button type="submit" class="public-button-primary">{{ __('Update password') }}</button>

            <x-action-message class="text-sm font-semibold text-emerald-300" on="password-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
