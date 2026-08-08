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
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-slate-300" aria-hidden="true">
                    {{-- Lucide: shopping-cart --}}
                    <svg class="h-7 w-7 fill-none stroke-current stroke-2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="8" cy="21" r="1" />
                        <circle cx="19" cy="21" r="1" />
                        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57L22 6H5.12" />
                    </svg>
                </div>
                <h2 class="mt-6 text-xl font-bold text-white">Your cart is empty</h2>
                <p class="mt-2 text-slate-400">The first products are coming soon.</p>
                <a href="{{ route('shop.index') }}" class="public-button-primary mt-7">Browse products</a>
            </div>
        @else
            @php
                $requiresShipping = $items->contains(fn (array $item) => $item['product']->type === \App\Models\Product::TYPE_BOARD_GAME);
            @endphp

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

            <div class="mt-6 rounded-2xl border border-white/10 bg-black/20 p-6">
                @auth
                    <form method="POST" action="{{ route('shop.checkout') }}">
                        @csrf

                        @if ($requiresShipping)
                            <div class="mb-7 border-b border-white/10 pb-7">
                                <p class="public-kicker">Physical delivery</p>
                                <h2 class="mt-2 text-xl font-extrabold text-white">Delivery address</h2>
                                <p class="mt-2 text-sm leading-6 text-amber-200">Startup Signals is a hard-copy product. Delivery is currently available only within North Macedonia.</p>

                                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                                    <div class="sm:col-span-2">
                                        <label for="shipping_name" class="public-form-label">Full name</label>
                                        <input id="shipping_name" name="shipping_name" value="{{ old('shipping_name', $deliveryAddress['shipping_name'] ?? auth()->user()->name) }}" autocomplete="name" class="public-form-input mt-2 w-full" required>
                                    </div>
                                    <div>
                                        <label for="shipping_phone" class="public-form-label">Phone number</label>
                                        <input id="shipping_phone" name="shipping_phone" value="{{ old('shipping_phone', $deliveryAddress['shipping_phone'] ?? '') }}" autocomplete="tel" class="public-form-input mt-2 w-full" required>
                                    </div>
                                    <div>
                                        <label for="shipping_postal_code" class="public-form-label">Postal code</label>
                                        <input id="shipping_postal_code" name="shipping_postal_code" value="{{ old('shipping_postal_code', $deliveryAddress['shipping_postal_code'] ?? '') }}" autocomplete="postal-code" class="public-form-input mt-2 w-full" required>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="shipping_address_line_1" class="public-form-label">Street and house/apartment number</label>
                                        <input id="shipping_address_line_1" name="shipping_address_line_1" value="{{ old('shipping_address_line_1', $deliveryAddress['shipping_address_line_1'] ?? '') }}" autocomplete="address-line1" class="public-form-input mt-2 w-full" required>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="shipping_address_line_2" class="public-form-label">Additional address details <span class="text-slate-500">(optional)</span></label>
                                        <input id="shipping_address_line_2" name="shipping_address_line_2" value="{{ old('shipping_address_line_2', $deliveryAddress['shipping_address_line_2'] ?? '') }}" autocomplete="address-line2" class="public-form-input mt-2 w-full">
                                    </div>
                                    <div>
                                        <label for="shipping_city" class="public-form-label">City</label>
                                        <input id="shipping_city" name="shipping_city" value="{{ old('shipping_city', $deliveryAddress['shipping_city'] ?? '') }}" autocomplete="address-level2" class="public-form-input mt-2 w-full" required>
                                    </div>
                                    <div>
                                        <label for="shipping_country_display" class="public-form-label">Country</label>
                                        <input id="shipping_country_display" value="North Macedonia" class="public-form-input mt-2 w-full opacity-80" disabled>
                                        <input type="hidden" name="shipping_country" value="MK">
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="flex flex-col items-stretch justify-between gap-6 sm:flex-row sm:items-center">
                            <div>
                                <p class="text-sm text-slate-400">Total</p>
                                <p class="mt-1 text-3xl font-extrabold text-white">{{ number_format($total / 100, 2) }} {{ $items->first()['product']->currency }}</p>
                            </div>
                            <button type="submit" class="public-button-primary w-full sm:w-auto">Continue to secure checkout</button>
                        </div>
                    </form>
                @else
                    <div class="flex flex-col items-stretch justify-between gap-6 sm:flex-row sm:items-center">
                        <div>
                            <p class="text-sm text-slate-400">Total</p>
                            <p class="mt-1 text-3xl font-extrabold text-white">{{ number_format($total / 100, 2) }} {{ $items->first()['product']->currency }}</p>
                        </div>
                        <div class="flex flex-col gap-2 sm:items-end">
                            <a href="{{ route('login') }}" class="public-button-primary">Sign in to checkout</a>
                            <a href="{{ route('register') }}" class="public-text-link text-center text-xs">New here? Create an account</a>
                        </div>
                    </div>
                @endauth
            </div>
        @endif
    </section>
</x-guest-layout>
