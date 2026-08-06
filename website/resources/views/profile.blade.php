<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold leading-tight text-white">
            {{ __('Profile & purchases') }}
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <section class="rounded-3xl border border-white/10 bg-[#12151a] p-5 shadow-2xl shadow-black/20 sm:p-8" aria-labelledby="orders-title">
                <div class="flex flex-col gap-3 border-b border-white/10 pb-6 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="public-kicker">Purchase history</p>
                        <h2 id="orders-title" class="mt-2 text-2xl font-extrabold text-white">My orders</h2>
                    </div>
                    <a href="{{ route('shop.index') }}" class="public-text-link text-sm">Continue shopping</a>
                </div>

                @if ($orders->isEmpty())
                    <div class="py-10 text-center">
                        <p class="font-semibold text-white">No orders yet</p>
                        <p class="mt-2 text-sm text-slate-400">Your one-time purchases will appear here.</p>
                    </div>
                @else
                    <div class="divide-y divide-white/10">
                        @foreach ($orders as $order)
                            <article class="py-6">
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
                                        <li class="flex items-center justify-between gap-4 rounded-xl bg-white/[0.04] px-4 py-3 text-sm">
                                            <span class="text-slate-300">{{ $item->product_name }} <span class="text-slate-600">× {{ $item->quantity }}</span></span>
                                            <span class="shrink-0 font-semibold text-slate-200">{{ number_format(($item->unit_price * $item->quantity) / 100, 2) }} {{ $order->currency }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </article>
                        @endforeach
                    </div>
                @endif
            </section>

            <section class="p-4 sm:p-8 bg-base-100 shadow sm:rounded-lg" aria-labelledby="downloads-title">
                <div class="max-w-3xl">
                    <h2 id="downloads-title" class="text-xl font-semibold text-base-content">My downloads</h2>
                    <p class="mt-1 text-sm text-base-content/70">Your purchased e-books are available here whenever you need them.</p>

                    @if ($downloads->isEmpty())
                        <div class="mt-5 rounded-xl border border-base-300 bg-base-200/50 p-5">
                            <p class="font-medium text-base-content">No e-books yet</p>
                            <p class="mt-1 text-sm text-base-content/70">Purchased e-books will appear after Paddle confirms payment.</p>
                            <a href="{{ route('shop.index') }}" class="btn btn-primary btn-sm mt-4">Visit the shop</a>
                        </div>
                    @else
                        <div class="mt-5 grid gap-4 sm:grid-cols-2">
                            @foreach ($downloads as $product)
                                <article class="rounded-xl border border-base-300 p-5">
                                    <p class="font-semibold text-base-content">{{ $product->name }}</p>
                                    <p class="mt-2 text-sm leading-6 text-base-content/70">{{ $product->description }}</p>
                                    <a href="{{ route('downloads.show', $product) }}" class="btn btn-primary btn-sm mt-4">Download PDF</a>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

            <div class="p-4 sm:p-8 bg-base-100 shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="max-w-xl">
                        <livewire:profile.update-profile-information-form />
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-base-100 shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="max-w-xl">
                        <livewire:profile.update-password-form />
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-base-100 shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="max-w-xl">
                        <livewire:profile.delete-user-form />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
