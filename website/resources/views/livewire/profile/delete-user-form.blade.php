<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-base-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-base-700">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="btn btn-error"
    >
        {{ __('Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-6 bg-base-100">
            <h2 class="text-lg font-medium text-base-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-base-700">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <label class="form-control w-full max-w-xs">
                    <div class="label">
                        <span class="label-text">{{ __('Password') }}</span>
                    </div>
                    <input
                        wire:model="password"
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Enter your password"
                        class="input input-bordered w-full max-w-xs"
                    />
                    <div class="label">
                        <span class="label-text-alt text-error">{{ $errors->first('password') }}</span>
                    </div>
                </label>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="btn btn-secondary"
                >
                    {{ __('Cancel') }}
                </button>

                <button
                    type="submit"
                    class="btn btn-error"
                >
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
