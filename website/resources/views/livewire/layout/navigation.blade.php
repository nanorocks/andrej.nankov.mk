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
    <nav class="items-center hidden gap-1 lg:flex" aria-label="Account navigation">
        <a href="{{ route('orders.index') }}" class="public-nav-link {{ request()->routeIs('orders.*') ? 'public-nav-link-active' : '' }}" @if (request()->routeIs('orders.*')) aria-current="page" @endif>Orders</a>
        <a href="{{ route('shop.index') }}" class="public-shop-cta">Shop</a>
        <a href="{{ route('shop.cart') }}" class="public-cart-link" aria-label="Shopping cart with {{ app(\App\Support\ShoppingCart::class)->count() }} items">
            {{-- Lucide: shopping-cart --}}
            <svg viewBox="0 0 24 24" aria-hidden="true" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="8" cy="21" r="1" />
                <circle cx="19" cy="21" r="1" />
                <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57L22 6H5.12" />
            </svg>
            <span>{{ app(\App\Support\ShoppingCart::class)->count() }}</span>
        </a>
    </nav>

    <details class="relative">
        <summary class="flex cursor-pointer list-none items-center gap-3 rounded-xl border border-white/10 bg-white/5 px-2 py-1.5 text-sm font-semibold text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-500">
            <span class="overflow-hidden bg-black border-2 rounded-full h-9 w-9 border-red-500/80" aria-hidden="true">
                <img src="{{ asset('assets/avatars/andrej-nankov-profile.png') }}" alt="" width="40" height="40" class="object-cover w-full h-full">
            </span>
            <span class="hidden truncate max-w-32 sm:inline">{{ auth()->user()->name }}</span>
            <span class="text-slate-500" aria-hidden="true">&#9662;</span>
        </summary>

        <nav class="public-mobile-menu" aria-label="User menu">
            <a class="lg:hidden" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="lg:hidden" href="{{ route('shop.index') }}">Shop</a>
            <a class="lg:hidden" href="{{ route('orders.index') }}">My orders</a>
            <a class="lg:hidden" href="{{ route('shop.cart') }}">Cart ({{ app(\App\Support\ShoppingCart::class)->count() }})</a>
            <a href="{{ route('profile') }}">Profile &amp; downloads</a>
            @if (auth()->user()->canAccessPanel(\Filament\Facades\Filament::getPanel('admin')))
                <a href="{{ route('filament.admin.home') }}">Administration</a>
            @endif
            <a href="{{ route('home') }}">View website</a>
            <button type="button" wire:click="logout" class="px-4 py-3 text-left text-red-300 rounded-lg hover:bg-white/10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-red-500">
                Sign out
            </button>
        </nav>
    </details>
</div>
