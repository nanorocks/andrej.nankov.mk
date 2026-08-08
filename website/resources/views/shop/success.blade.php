@php
    $physicalItems = $order->items->filter(fn ($item) => $item->product?->type === \App\Models\Product::TYPE_BOARD_GAME);
    $ebookItems = $order->items->filter(fn ($item) => $item->product?->type === \App\Models\Product::TYPE_EBOOK);
@endphp

<x-guest-layout>
    <section class="public-panel mx-auto max-w-3xl" aria-labelledby="success-title" aria-live="polite">
        <div class="text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full border {{ $order->isCompleted() ? 'border-emerald-400/30 bg-emerald-500/10 text-emerald-300' : 'border-amber-400/30 bg-amber-500/10 text-amber-200' }} text-2xl" aria-hidden="true">
                {{ $order->isCompleted() ? '✓' : '…' }}
            </div>
            <p class="public-kicker mt-7">Order #{{ $order->id }}</p>
            <h1 id="success-title" class="public-section-title mt-3">
                {{ $order->isCompleted() ? 'Payment confirmed' : 'Payment confirmation in progress' }}
            </h1>
            <p class="mx-auto mt-4 max-w-xl leading-7 text-slate-300">
                @if ($order->isCompleted())
                    Your order is paid and recorded in your account.
                @else
                    Paddle has returned you to the store. The signed payment confirmation is still being processed; this page does not require another payment.
                @endif
            </p>
        </div>

        @if ($physicalItems->isNotEmpty())
            <div class="mt-8 rounded-2xl border border-sky-400/20 bg-sky-500/[0.07] p-5 sm:p-6">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="public-kicker">Physical delivery</p>
                        <h2 class="mt-2 text-xl font-extrabold text-white">
                            {{ $order->isCompleted() ? 'Your physical order is confirmed' : 'Your physical order is awaiting payment confirmation' }}
                        </h2>
                    </div>
                    <span class="w-fit rounded-full border border-sky-400/25 bg-sky-500/10 px-3 py-1 text-xs font-bold uppercase tracking-wider text-sky-200">
                        {{ $order->customerDeliveryStatusLabel() ?? 'Awaiting confirmation' }}
                    </span>
                </div>

                <ul class="mt-5 space-y-2 text-sm text-slate-300" aria-label="Physical products">
                    @foreach ($physicalItems as $item)
                        <li>{{ $item->product_name }} <span class="text-slate-500">× {{ $item->quantity }}</span></li>
                    @endforeach
                </ul>

                @if ($order->shipping_address_line_1)
                    <div class="mt-5 border-t border-white/10 pt-5 text-sm leading-6 text-slate-400">
                        <p class="font-semibold text-slate-200">Delivery address</p>
                        <p>{{ $order->shipping_name }} · {{ $order->shipping_phone }}</p>
                        <p>{{ $order->shipping_address_line_1 }}{{ $order->shipping_address_line_2 ? ', '.$order->shipping_address_line_2 : '' }}</p>
                        <p>{{ $order->shipping_postal_code }} {{ $order->shipping_city }}, North Macedonia</p>
                    </div>
                @endif

                <p class="mt-5 text-sm leading-6 text-slate-400">
                    @if ($order->isCompleted())
                        You can follow the delivery marker—from ready to ship through delivered—in your order history.
                    @else
                        Delivery processing starts automatically after Paddle's signed confirmation arrives.
                    @endif
                </p>
            </div>
        @endif

        @if ($ebookItems->isNotEmpty())
            <div class="mt-6 rounded-2xl border border-white/10 bg-black/20 p-5 sm:p-6">
                <p class="public-kicker">Digital delivery</p>
                <h2 class="mt-2 text-xl font-extrabold text-white">
                    {{ $order->isCompleted() ? 'Your e-book is ready' : 'Your download is being unlocked' }}
                </h2>

                <div class="mt-5 space-y-3">
                    @foreach ($ebookItems as $item)
                        <div class="flex flex-col gap-3 rounded-xl bg-white/[0.04] px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
                            <span class="font-semibold text-slate-200">{{ $item->product_name }}</span>
                            @if ($order->isCompleted() && $item->product)
                                <form method="POST" action="{{ route('downloads.show', $item->product) }}">
                                    @csrf
                                    <button type="submit" class="public-button-primary px-4 py-2">Download PDF</button>
                                </form>
                            @else
                                <span class="text-sm text-amber-200">Waiting for payment confirmation</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ route('orders.index') }}" class="public-button-primary">View order history</a>
            @if ($ebookItems->isNotEmpty())
                <a href="{{ route('profile') }}" class="public-button-secondary">My downloads</a>
            @else
                <a href="{{ route('shop.index') }}" class="public-button-secondary">Return to shop</a>
            @endif
        </div>
    </section>

    @unless ($order->isCompleted())
        <script>
            (() => {
                const statusUrl = @js(route('shop.checkout.status', $order));
                let polling = false;

                const checkPaymentStatus = async () => {
                    if (polling || document.hidden) return;

                    polling = true;

                    try {
                        const response = await fetch(statusUrl, {
                            credentials: 'same-origin',
                            headers: { 'Accept': 'application/json' },
                            cache: 'no-store',
                        });

                        if (response.ok && (await response.json()).completed) {
                            window.location.reload();
                        }
                    } finally {
                        polling = false;
                    }
                };

                const interval = window.setInterval(checkPaymentStatus, 2000);
                window.addEventListener('pagehide', () => window.clearInterval(interval), { once: true });
                document.addEventListener('visibilitychange', () => {
                    if (! document.hidden) checkPaymentStatus();
                });
                checkPaymentStatus();
            })();
        </script>
    @endunless
</x-guest-layout>
