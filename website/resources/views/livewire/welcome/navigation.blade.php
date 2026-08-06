<div class="flex items-center gap-2">
    <nav class="hidden items-center gap-1 md:flex" aria-label="Primary navigation">
        @foreach ([
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'about', 'label' => 'About'],
            ['route' => 'newsletter', 'label' => 'Newsletter'],
            ['route' => 'shop.index', 'label' => 'Shop'],
        ] as $item)
            <a href="{{ route($item['route']) }}"
                @if (request()->routeIs($item['route'])) aria-current="page" @endif
                class="public-nav-link {{ request()->routeIs($item['route']) ? 'public-nav-link-active' : '' }}">
                {{ $item['label'] }}
            </a>
        @endforeach

        <a href="https://medium.com/@nanorocks" target="_blank" rel="noopener noreferrer" class="public-nav-link">Blog</a>
        <a href="{{ route('get.started') }}" class="public-nav-cta">Let's talk</a>
        <a href="{{ route('shop.cart') }}" class="public-cart-link" aria-label="Shopping cart with {{ app(\App\Support\ShoppingCart::class)->count() }} items">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 4h2l2.2 10.1a2 2 0 0 0 2 1.6h7.9a2 2 0 0 0 2-1.6L20.5 8H6.2M10 20h.01M17 20h.01" /></svg>
            <span>{{ app(\App\Support\ShoppingCart::class)->count() }}</span>
        </a>

        @auth
            <a href="{{ route('orders.index') }}" class="public-nav-link {{ request()->routeIs('orders.*') ? 'public-nav-link-active' : '' }}">Orders</a>
            <a href="{{ route('profile') }}" class="public-nav-link">Profile</a>
            @if (auth()->user()->canAccessPanel(\Filament\Facades\Filament::getPanel('admin')))
                <a href="{{ route('filament.admin.home') }}" class="public-nav-link" aria-label="Open administration panel">Admin</a>
            @endif
        @else
            <a href="{{ route('login') }}" class="public-nav-link">Sign in</a>
            <a href="{{ route('register') }}" class="public-button-secondary px-4 py-2">Create account</a>
        @endauth
    </nav>

    <details class="relative md:hidden">
        <summary class="public-menu-button">Menu</summary>
        <nav class="public-mobile-menu" aria-label="Mobile navigation">
            <a href="{{ route('home') }}" @if (request()->routeIs('home')) aria-current="page" @endif>Home</a>
            <a href="{{ route('about') }}" @if (request()->routeIs('about')) aria-current="page" @endif>About</a>
            <a href="{{ route('newsletter') }}" @if (request()->routeIs('newsletter')) aria-current="page" @endif>Newsletter</a>
            <a href="{{ route('shop.index') }}" @if (request()->routeIs('shop.*')) aria-current="page" @endif>Shop</a>
            <a href="{{ route('shop.cart') }}">Cart ({{ app(\App\Support\ShoppingCart::class)->count() }})</a>
            <a href="https://medium.com/@nanorocks" target="_blank" rel="noopener noreferrer">Blog</a>
            <a href="{{ route('get.started') }}" @if (request()->routeIs('get.started')) aria-current="page" @endif>Let's talk</a>
            <a href="mailto:andrejnankov@gmail.com">Contact</a>
            <a href="https://support.nankov.mk" target="_blank" rel="noopener noreferrer">Support</a>
            @auth
                <a href="{{ route('orders.index') }}">My orders</a>
                <a href="{{ route('profile') }}">Profile &amp; downloads</a>
                @if (auth()->user()->canAccessPanel(\Filament\Facades\Filament::getPanel('admin')))
                    <a href="{{ route('filament.admin.home') }}">Admin</a>
                @endif
            @else
                <a href="{{ route('login') }}">Sign in</a>
                <a href="{{ route('register') }}">Create account</a>
            @endauth
        </nav>
    </details>
</div>
