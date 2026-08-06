<div class="flex items-center gap-2">
    <nav class="items-center hidden gap-1 md:flex" aria-label="Primary navigation">
        <a href="{{ route('get.started') }}"
            class="public-nav-link {{ request()->routeIs('get.started') ? 'public-nav-link-active' : '' }}"
            @if (request()->routeIs('get.started')) aria-current="page" @endif>
            Work with me
        </a>

        <a href="{{ route('shop.index') }}"
            class="public-shop-cta {{ request()->routeIs('shop.index') ? 'public-shop-cta-active' : '' }}"
            @if (request()->routeIs('shop.index')) aria-current="page" @endif>
            Shop
        </a>

        <a href="{{ route('shop.cart') }}" class="public-cart-link" aria-label="Shopping cart with {{ app(\App\Support\ShoppingCart::class)->count() }} items">
            {{-- Lucide: shopping-cart --}}
            <svg viewBox="0 0 24 24" aria-hidden="true" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="8" cy="21" r="1" />
                <circle cx="19" cy="21" r="1" />
                <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57L22 6H5.12" />
            </svg>
            <span>{{ app(\App\Support\ShoppingCart::class)->count() }}</span>
        </a>

        @auth
            <details class="relative ml-1">
                <summary class="flex cursor-pointer list-none items-center gap-2 rounded-xl border border-white/10 bg-white/5 py-1.5 pl-1.5 pr-3 text-sm font-semibold text-white hover:border-white/20 hover:bg-white/[0.08] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-500">
                    <span class="h-8 w-8 overflow-hidden rounded-full border border-red-500/70 bg-black" aria-hidden="true">
                        <img src="{{ asset('assets/avatars/andrej-nankov-profile.png') }}" alt="" width="32" height="32" class="h-full w-full object-cover">
                    </span>
                    <span class="max-w-28 truncate">{{ auth()->user()->name }}</span>
                    <span class="text-xs text-slate-500" aria-hidden="true">&#9662;</span>
                </summary>

                <nav class="public-mobile-menu" aria-label="Customer menu">
                    <div class="border-b border-white/10 px-4 py-3">
                        <p class="truncate font-semibold text-white">{{ auth()->user()->name }}</p>
                        <p class="mt-1 truncate text-xs font-normal text-slate-500">{{ auth()->user()->email }}</p>
                    </div>
                    <a href="{{ route('orders.index') }}">My orders</a>
                    <a href="{{ route('profile') }}">Profile &amp; downloads</a>
                    @if (auth()->user()->canAccessPanel(\Filament\Facades\Filament::getPanel('admin')))
                        <a href="{{ route('filament.admin.home') }}">Administration</a>
                    @endif
                    <a href="{{ route('logout') }}" class="text-red-300">Sign out</a>
                </nav>
            </details>
        @else
            <a href="{{ route('login') }}" class="public-account-link">Sign in</a>
        @endauth
    </nav>

    <details class="relative md:hidden">
        <summary class="public-menu-button">Menu</summary>
        <nav class="public-mobile-menu" aria-label="Mobile navigation">
            <p class="px-4 pb-2 pt-3 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">Explore</p>
            <a href="{{ route('get.started') }}" @if (request()->routeIs('get.started')) aria-current="page" @endif>Work with me</a>
            <a href="{{ route('shop.index') }}" @if (request()->routeIs('shop.*')) aria-current="page" @endif>Shop</a>
            <a href="{{ route('shop.cart') }}">Cart ({{ app(\App\Support\ShoppingCart::class)->count() }})</a>

            <div class="my-2 border-t border-white/10"></div>

            @auth
                <div class="border-b border-white/10 px-4 pb-3">
                    <p class="truncate font-semibold text-white">{{ auth()->user()->name }}</p>
                    <p class="mt-1 truncate text-xs font-normal text-slate-500">{{ auth()->user()->email }}</p>
                </div>
                <a href="{{ route('orders.index') }}">My orders</a>
                <a href="{{ route('profile') }}">Profile &amp; downloads</a>
                @if (auth()->user()->canAccessPanel(\Filament\Facades\Filament::getPanel('admin')))
                    <a href="{{ route('filament.admin.home') }}">Administration</a>
                @endif
                <a href="{{ route('logout') }}" class="text-red-300">Sign out</a>
            @else
                <a href="{{ route('login') }}">Sign in</a>
                <a href="{{ route('register') }}">Create account</a>
            @endauth
        </nav>
    </details>
</div>
