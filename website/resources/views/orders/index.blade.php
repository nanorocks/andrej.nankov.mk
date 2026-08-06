<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="public-kicker">Your purchases</p>
                <h1 class="mt-2 text-2xl font-extrabold text-white">Order history</h1>
            </div>
            <a href="{{ route('shop.index') }}" class="public-button-secondary">Continue shopping</a>
        </div>
    </x-slot>

    <section class="rounded-3xl border border-white/10 bg-[#12151a] p-5 shadow-2xl shadow-black/20 sm:p-8" aria-labelledby="orders-title">
        <div class="border-b border-white/10 pb-6">
            <h2 id="orders-title" class="text-xl font-bold text-white">All orders</h2>
            <p class="mt-2 text-sm leading-6 text-slate-400">Only purchases made with this account are shown here.</p>
        </div>

        @if ($orders->isEmpty())
            <div class="py-12 text-center">
                <p class="font-semibold text-white">No orders yet</p>
                <p class="mt-2 text-sm text-slate-400">Your one-time purchases will appear here after checkout.</p>
                <a href="{{ route('shop.index') }}" class="public-nav-cta mt-6 inline-flex">Browse the shop</a>
            </div>
        @else
            <div class="divide-y divide-white/10">
                @foreach ($orders as $order)
                    <article class="py-7">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <div class="flex flex-wrap items-center gap-3">
                                    <h3 class="font-bold text-white">Order #{{ $order->id }}</h3>
                                    <span class="rounded-full border px-3 py-1 text-[11px] font-bold uppercase tracking-wider {{ $order->isCompleted() ? 'border-emerald-400/30 bg-emerald-500/10 text-emerald-300' : 'border-amber-400/30 bg-amber-500/10 text-amber-200' }}">
                                        {{ $order->isCompleted() ? 'Completed' : 'Processing' }}
                                    </span>
                                </div>
                                <p class="mt-2 text-sm text-slate-500">Placed {{ $order->created_at->format('M j, Y') }}</p>
                            </div>
                            <p class="text-lg font-extrabold text-white">{{ number_format($order->total / 100, 2) }} {{ $order->currency }}</p>
                        </div>

                        <ul class="mt-5 space-y-2" aria-label="Items in order {{ $order->id }}">
                            @foreach ($order->items as $item)
                                <li class="flex flex-col gap-3 rounded-xl bg-white/[0.04] px-4 py-3 text-sm sm:flex-row sm:items-center sm:justify-between">
                                    <span class="text-slate-300">{{ $item->product_name }} <span class="text-slate-600">× {{ $item->quantity }}</span></span>
                                    <div class="flex shrink-0 items-center gap-4">
                                        <span class="font-semibold text-slate-200">{{ number_format(($item->unit_price * $item->quantity) / 100, 2) }} {{ $order->currency }}</span>
                                        @if ($order->isCompleted() && $item->product?->type === \App\Models\Product::TYPE_EBOOK)
                                            <a href="{{ route('downloads.show', $item->product) }}" class="public-text-link font-semibold">Download</a>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
</x-app-layout>
