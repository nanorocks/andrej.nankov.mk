<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>
<section>
    <header>
        <h2 class="text-lg font-medium text-base-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-base-700">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div>
            <label class="form-control w-full max-w-xs">
                <div class="label">
                    <span class="label-text">{{ __('Name') }}</span>
                </div>
                <input type="text" wire:model="name" id="name" name="name" placeholder="Type your name" class="input input-bordered w-full max-w-xs" required autofocus autocomplete="name" />
                <div class="label">
                    <span class="label-text-alt text-error">{{ $errors->first('name') }}</span>
                    <span class="label-text-alt"></span>
                </div>
            </label>
        </div>

        <div>
            <label class="form-control w-full max-w-xs">
                <div class="label">
                    <span class="label-text">{{ __('Email') }}</span>
                </div>
                <input type="email" wire:model="email" id="email" name="email" placeholder="Type your email" class="input input-bordered w-full max-w-xs" required autocomplete="username" />
                <div class="label">
                    <span class="label-text-alt text-error">{{ $errors->first('email') }}</span>
                    <span class="label-text-alt"></span>
                </div>
            </label>

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-base-700">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification" class="underline text-sm text-primary hover:text-primary-dark rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-success">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

            <x-action-message class="me-3 text-success" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>

