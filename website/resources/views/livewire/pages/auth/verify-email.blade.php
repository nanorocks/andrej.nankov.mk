<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="auth-shell" aria-labelledby="verify-email-title">
    <div class="auth-card text-center">
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl border border-red-400/30 bg-red-500/10 text-2xl" aria-hidden="true">✉</div>
        <p class="public-kicker mt-6">One last step</p>
        <h1 id="verify-email-title" class="mt-3 text-3xl font-extrabold tracking-tight text-white">Verify your email</h1>
        <p class="mx-auto mt-3 max-w-md leading-7 text-slate-400">Open the verification link we sent you to protect your purchases, order history, and downloads.</p>

        @if (session('status') == 'verification-link-sent')
            <div class="public-alert-success mt-6" role="status">A new verification link has been sent.</div>
        @endif

        <div class="mt-7 flex flex-col gap-3 sm:flex-row sm:justify-center">
            <button wire:click="sendVerification" type="button" class="public-button-primary" wire:loading.attr="disabled">Resend verification email</button>
            <button wire:click="logout" type="button" class="public-button-secondary">Sign out</button>
        </div>
    </div>
</section>
