<x-guest-layout>
    @php
        seo(new \RalphJSmit\Laravel\SEO\Support\SEOData(
            title: 'Shopping Cart — Andrej Nankov',
            description: 'Review your selected board games and e-books.',
            robots: 'noindex,nofollow',
        ));
    @endphp

    <section class="public-panel" aria-labelledby="cart-title">
        <div class="flex flex-col justify-between gap-4 border-b border-white/10 pb-7 sm:flex-row sm:items-end">
            <div>
                <p class="public-kicker">Your selection</p>
                <h1 id="cart-title" class="public-section-title mt-3">Shopping cart</h1>
            </div>
            <a href="{{ route('shop.index') }}" class="public-text-link">Continue shopping</a>
        </div>

        @if (session('success'))
            <div class="public-alert-success" role="status">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="public-alert-error" role="alert">{{ $errors->first() }}</div>
        @endif

        @if ($items->isEmpty())
            <div class="py-16 text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-2xl" aria-hidden="true">🛒</div>
                <h2 class="mt-6 text-xl font-bold text-white">Your cart is empty</h2>
                <p class="mt-2 text-slate-400">The first products are coming soon.</p>
                <a href="{{ route('shop.index') }}" class="public-button-primary mt-7">Browse products</a>
            </div>
        @else
            <div class="divide-y divide-white/10">
                @foreach ($items as $item)
                    <article class="grid gap-5 py-7 sm:grid-cols-[minmax(0,1fr)_auto] sm:items-center">
                        <div>
                            <p class="text-lg font-bold text-white">{{ $item['product']->name }}</p>
                            <p class="mt-1 text-sm text-slate-400">{{ $item['product']->formattedPrice() }} each</p>
                        </div>

                        <div class="flex flex-wrap items-center gap-3">
                            <form method="POST" action="{{ route('shop.cart.update', $item['product']) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <label for="quantity-{{ $item['product']->id }}" class="sr-only">Quantity for {{ $item['product']->name }}</label>
                                <input id="quantity-{{ $item['product']->id }}" name="quantity" type="number" min="0" max="10" value="{{ $item['quantity'] }}" class="public-form-input w-20 py-2">
                                <button type="submit" class="public-button-secondary px-4 py-2">Update</button>
                            </form>
                            <form method="POST" action="{{ route('shop.cart.destroy', $item['product']) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="public-text-link text-red-300">Remove</button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-6 flex flex-col items-stretch justify-between gap-6 rounded-2xl border border-white/10 bg-black/20 p-6 sm:flex-row sm:items-center">
                <div>
                    <p class="text-sm text-slate-400">Total</p>
                    <p class="mt-1 text-3xl font-extrabold text-white">{{ number_format($total / 100, 2) }} {{ $items->first()['product']->currency }}</p>
                </div>

                @auth
                    <form method="POST" action="{{ route('shop.checkout') }}">
                        @csrf
                        <button type="submit" class="public-button-primary w-full sm:w-auto">Continue to secure checkout</button>
                    </form>
                @else
                    <div class="flex flex-col gap-2 sm:items-end">
                        <a href="{{ route('login') }}" class="public-button-primary">Sign in to checkout</a>
                        <a href="{{ route('register') }}" class="public-text-link text-center text-xs">New here? Create an account</a>
                    </div>
                @endauth
            </div>
        @endif
    </section>
</x-guest-layout>
