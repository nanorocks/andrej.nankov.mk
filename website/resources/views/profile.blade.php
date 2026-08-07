<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="public-kicker">Customer account</p>
                <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-white">Profile &amp; downloads</h1>
                <p class="mt-2 text-sm text-slate-400">Manage your details, security, purchases, and digital products.</p>
            </div>
            <a href="{{ route('shop.index') }}" class="public-shop-cta">Shop products</a>
        </div>
    </x-slot>

    <div class="space-y-6">
            <section class="rounded-3xl border border-white/10 bg-[#12151a] p-5 shadow-2xl shadow-black/20 sm:p-8" aria-labelledby="transactions-title">
                <div class="flex flex-col gap-3 border-b border-white/10 pb-6 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="public-kicker">Billing record</p>
                        <h2 id="transactions-title" class="mt-2 text-2xl font-extrabold text-white">Payment transactions</h2>
                    </div>
                    <a href="{{ route('orders.index') }}" class="public-text-link text-sm">View order history</a>
                </div>

                @if ($transactions->isEmpty())
                    <div class="py-10 text-center">
                        <p class="font-semibold text-white">No payment transactions yet</p>
                        <p class="mt-2 text-sm text-slate-400">Completed Paddle payments will appear here.</p>
                    </div>
                @else
                    <div class="divide-y divide-white/10">
                        @foreach ($transactions as $transaction)
                            <article class="flex flex-col gap-3 py-5 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="font-semibold text-white">{{ $transaction->paddle_id }}</p>
                                    <p class="mt-1 text-sm text-slate-500">Billed {{ $transaction->billed_at->format('M j, Y') }}</p>
                                </div>
                                <div class="sm:text-right">
                                    <p class="font-bold text-white">{{ number_format(((int) $transaction->total) / 100, 2) }} {{ strtoupper($transaction->currency) }}</p>
                                    <p class="mt-1 text-xs font-bold uppercase tracking-wider text-emerald-300">{{ $transaction->status }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </section>

            <section class="rounded-3xl border border-white/10 bg-[#12151a] p-5 shadow-2xl shadow-black/20 sm:p-8" aria-labelledby="downloads-title">
                <div class="border-b border-white/10 pb-6">
                    <p class="public-kicker">Digital library</p>
                    <h2 id="downloads-title" class="mt-2 text-2xl font-extrabold text-white">My downloads</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-400">Your purchased e-books remain available from this account.</p>
                </div>

                    @if ($downloads->isEmpty())
                        <div class="py-10 text-center">
                            <p class="font-semibold text-white">No e-books yet</p>
                            <p class="mt-2 text-sm text-slate-400">Purchased e-books appear after Paddle confirms payment.</p>
                            <a href="{{ route('shop.index') }}" class="public-button-secondary mt-6">Browse e-books</a>
                        </div>
                    @else
                        <div class="mt-6 grid gap-4 sm:grid-cols-2">
                            @foreach ($downloads as $product)
                                <article class="rounded-2xl border border-white/10 bg-white/[0.03] p-5">
                                    <p class="font-bold text-white">{{ $product->name }}</p>
                                    <p class="mt-2 text-sm leading-6 text-slate-400">{{ $product->description }}</p>
                                    <form method="POST" action="{{ route('downloads.show', $product) }}" class="mt-5">
                                        @csrf
                                        <button type="submit" class="public-button-primary">Download PDF</button>
                                    </form>
                                </article>
                            @endforeach
                        </div>
                    @endif
            </section>

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="rounded-3xl border border-white/10 bg-[#12151a] p-5 shadow-2xl shadow-black/20 sm:p-8">
                    <livewire:profile.update-profile-information-form />
                </div>

                <div class="rounded-3xl border border-white/10 bg-[#12151a] p-5 shadow-2xl shadow-black/20 sm:p-8">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="rounded-3xl border border-red-500/20 bg-red-500/[0.04] p-5 sm:p-8">
                <livewire:profile.delete-user-form />
            </div>
    </div>
</x-app-layout>
