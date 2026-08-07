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

<section class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
    <header class="max-w-3xl">
        <p class="text-xs font-bold uppercase tracking-[0.22em] text-red-300">Danger zone</p>
        <h2 class="mt-2 text-xl font-extrabold text-white">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-2 text-sm leading-6 text-slate-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex shrink-0 items-center justify-center rounded-xl border border-red-400/30 bg-red-500/10 px-5 py-3 text-sm font-bold text-red-200 hover:border-red-400/60 hover:bg-red-500/20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-500"
    >
        {{ __('Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="bg-[#12151a] p-6 sm:p-8">
            <p class="text-xs font-bold uppercase tracking-[0.22em] text-red-300">Permanent action</p>
            <h2 class="mt-2 text-xl font-extrabold text-white">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-3 text-sm leading-6 text-slate-400">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <label class="block">
                    <span class="auth-label">{{ __('Password') }}</span>
                    <input
                        wire:model="password"
                        id="delete_account_password"
                        name="delete_account_password"
                        type="password"
                        placeholder="Enter your current password"
                        class="public-form-input mt-2"
                        autocomplete="current-password"
                        required
                    />
                    @error('password') <span class="mt-2 block text-sm text-red-300">{{ $message }}</span> @enderror
                </label>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="public-button-secondary"
                >
                    {{ __('Cancel') }}
                </button>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-xl bg-red-500 px-5 py-3 text-sm font-bold text-white hover:bg-red-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-500"
                >
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
