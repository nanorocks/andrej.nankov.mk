<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="flex items-center gap-2">
    <nav class="hidden items-center gap-1 lg:flex" aria-label="Account navigation">
        <a href="{{ route('dashboard') }}" class="public-nav-link {{ request()->routeIs('dashboard') ? 'public-nav-link-active' : '' }}" @if (request()->routeIs('dashboard')) aria-current="page" @endif>
            Dashboard
        </a>
        <a href="{{ route('shop.index') }}" class="public-nav-link">Shop</a>
        <a href="{{ route('shop.cart') }}" class="public-cart-link" aria-label="Shopping cart with {{ app(\App\Support\ShoppingCart::class)->count() }} items">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 4h2l2.2 10.1a2 2 0 0 0 2 1.6h7.9a2 2 0 0 0 2-1.6L20.5 8H6.2M10 20h.01M17 20h.01" /></svg>
            <span>{{ app(\App\Support\ShoppingCart::class)->count() }}</span>
        </a>
    </nav>

    <details class="relative">
        <summary class="flex cursor-pointer list-none items-center gap-3 rounded-xl border border-white/10 bg-white/5 px-2 py-1.5 text-sm font-semibold text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-500">
            <span class="h-9 w-9 overflow-hidden rounded-full border-2 border-red-500/80 bg-black" aria-hidden="true">
                <img src="{{ asset('assets/avatars/andrej-nankov-profile.png') }}" alt="" width="40" height="40" class="h-full w-full object-cover">
            </span>
            <span class="hidden max-w-32 truncate sm:inline">{{ auth()->user()->name }}</span>
            <span class="text-slate-500" aria-hidden="true">&#9662;</span>
        </summary>

        <nav class="public-mobile-menu" aria-label="User menu">
            <a class="lg:hidden" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="lg:hidden" href="{{ route('shop.index') }}">Shop</a>
            <a class="lg:hidden" href="{{ route('shop.cart') }}">Cart ({{ app(\App\Support\ShoppingCart::class)->count() }})</a>
            <a href="{{ route('profile') }}">Profile &amp; downloads</a>
            <a href="{{ route('home') }}">View website</a>
            <button type="button" wire:click="logout" class="rounded-lg px-4 py-3 text-left text-red-300 hover:bg-white/10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-red-500">
                Sign out
            </button>
        </nav>
    </details>
</div>
