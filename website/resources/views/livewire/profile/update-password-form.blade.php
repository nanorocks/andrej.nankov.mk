<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
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
        <h2 class="text-lg font-medium text-base-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-base-700">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form wire:submit="updatePassword" class="mt-6 space-y-6">
        <div>
            <label class="form-control w-full max-w-xs">
                <div class="label">
                    <span class="label-text">{{ __('Current Password') }}</span>
                </div>
                <input type="password" wire:model="current_password" id="update_password_current_password" name="current_password" placeholder="Enter current password" class="input input-bordered w-full max-w-xs" autocomplete="current-password" />
                <div class="label">
                    <span class="label-text-alt text-error">{{ $errors->first('current_password') }}</span>
                </div>
            </label>
        </div>

        <div>
            <label class="form-control w-full max-w-xs">
                <div class="label">
                    <span class="label-text">{{ __('New Password') }}</span>
                </div>
                <input type="password" wire:model="password" id="update_password_password" name="password" placeholder="Enter new password" class="input input-bordered w-full max-w-xs" autocomplete="new-password" />
                <div class="label">
                    <span class="label-text-alt text-error">{{ $errors->first('password') }}</span>
                </div>
            </label>
        </div>

        <div>
            <label class="form-control w-full max-w-xs">
                <div class="label">
                    <span class="label-text">{{ __('Confirm Password') }}</span>
                </div>
                <input type="password" wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" placeholder="Confirm new password" class="input input-bordered w-full max-w-xs" autocomplete="new-password" />
                <div class="label">
                    <span class="label-text-alt text-error">{{ $errors->first('password_confirmation') }}</span>
                </div>
            </label>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

            <x-action-message class="me-3 text-success" on="password-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
