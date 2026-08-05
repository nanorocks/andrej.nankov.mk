<x-guest-layout>
    @php
        seo(new \RalphJSmit\Laravel\SEO\Support\SEOData(
            title: 'Shop — Board Games & E-books by Andrej Nankov',
            description: 'Practical products for founders, engineers, and thoughtful builders.',
            robots: 'index,follow',
            url: route('shop.index'),
        ));
    @endphp

    <div class="w-full">
        <header class="mx-auto max-w-3xl text-center">
            <p class="public-kicker">Tools for thoughtful builders</p>
            <h1 class="public-title">Play better. Build smarter.</h1>
            <p class="public-lead">
                Original board games and concise e-books about software, startups, and making good decisions under pressure.
            </p>
        </header>

        @if ($errors->any())
            <div class="public-alert-error mx-auto mt-8 max-w-2xl" role="alert">{{ $errors->first() }}</div>
        @endif

        <section class="mt-12 grid gap-7 md:grid-cols-2" aria-label="Products">
            @forelse ($products as $product)
                <article class="store-product-card">
                    <div class="store-product-art">
                        @if ($product->type === \App\Models\Product::TYPE_BOARD_GAME)
                            <div class="store-board-box" aria-hidden="true">
                                <span class="bg-red-500"></span><span class="bg-slate-800"></span><span class="bg-amber-400"></span>
                                <span class="bg-slate-800"></span><span class="bg-red-500"></span><span class="bg-slate-300"></span>
                                <span class="bg-amber-400"></span><span class="bg-slate-300"></span><span class="bg-red-500"></span>
                            </div>
                        @else
                            <div class="store-book-cover" aria-hidden="true">
                                <span class="text-xs font-bold uppercase tracking-[0.18em] text-red-100">Andrej Nankov</span>
                                <strong class="text-xl leading-tight">Practical<br>Systems<br>Playbook</strong>
                                <span class="text-[10px] uppercase tracking-widest text-red-100">Field guide</span>
                            </div>
                        @endif

                        @if ($product->is_coming_soon)
                            <div class="store-coming-soon"><span>Coming soon</span></div>
                        @endif
                    </div>

                    <div class="p-6 sm:p-8">
                        <div class="flex items-start justify-between gap-5">
                            <div>
                                <p class="public-kicker">{{ $product->type === \App\Models\Product::TYPE_EBOOK ? 'E-book' : 'Board game' }}</p>
                                <h2 class="mt-2 text-2xl font-extrabold text-white">{{ $product->name }}</h2>
                            </div>
                            <p class="shrink-0 text-lg font-bold text-white">{{ $product->formattedPrice() }}</p>
                        </div>

                        <p class="mt-4 leading-7 text-slate-400">{{ $product->description }}</p>

                        @if ($product->isPurchasable())
                            <form method="POST" action="{{ route('shop.cart.store', $product) }}" class="mt-6">
                                @csrf
                                <button class="public-button-primary w-full" type="submit">Add to cart</button>
                            </form>
                        @else
                            <button class="mt-6 w-full cursor-not-allowed rounded-xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-bold text-slate-500" type="button" disabled>
                                Not available yet
                            </button>
                        @endif
                    </div>
                </article>
            @empty
                <div class="public-panel col-span-full text-center text-slate-400">New products are being prepared.</div>
            @endforelse
        </section>

        <div class="mt-10 text-center">
            <a href="{{ route('shop.cart') }}" class="public-button-secondary">View cart ({{ $cartCount }})</a>
        </div>
    </div>
</x-guest-layout>
