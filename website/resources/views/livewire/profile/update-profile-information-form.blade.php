<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
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
        <p class="public-kicker">Account details</p>
        <h2 class="mt-2 text-xl font-extrabold text-white">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-2 text-sm leading-6 text-slate-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-7 space-y-5">
        <div>
            <label class="block">
                <span class="auth-label">{{ __('Name') }}</span>
                <input type="text" wire:model="name" id="name" name="name" placeholder="Type your name"
                    class="public-form-input mt-2" required autofocus autocomplete="name" />
                @error('name') <span class="mt-2 block text-sm text-red-300">{{ $message }}</span> @enderror
            </label>
        </div>

        <div>
            <label class="block">
                <span class="auth-label">{{ __('Email') }}</span>
                <input type="email" wire:model="email" id="email" name="email" placeholder="Type your email"
                    class="public-form-input mt-2" required autocomplete="username" />
                @error('email') <span class="mt-2 block text-sm text-red-300">{{ $message }}</span> @enderror
            </label>

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="mt-3 rounded-xl border border-amber-400/20 bg-amber-400/5 p-4 text-sm leading-6 text-amber-100">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification"
                            class="font-semibold text-amber-300 underline underline-offset-4 focus-visible:outline focus-visible:outline-2 focus-visible:outline-red-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-3 text-sm font-semibold text-emerald-300">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-1">
            <button type="submit" class="public-button-primary">{{ __('Save changes') }}</button>

            <x-action-message class="text-sm font-semibold text-emerald-300" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
