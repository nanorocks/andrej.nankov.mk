<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold leading-tight text-white">
            {{ __('Profile & purchases') }}
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
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
