@push('head')
    @paddleJS
@endpush

<x-guest-layout>
    <section class="public-panel mx-auto max-w-3xl text-center" aria-labelledby="checkout-title">
        <p class="public-kicker">Order #{{ $order->id }}</p>
        <h1 id="checkout-title" class="public-section-title mt-3">Complete your purchase</h1>
        <p class="mx-auto mt-4 max-w-xl leading-7 text-slate-400">
            Paddle securely handles payment and tax. Your order is unlocked only after Paddle confirms the transaction.
        </p>

        <x-paddle-button :checkout="$checkout" class="public-button-primary mt-8 px-8 py-4">
            Open secure Paddle checkout
        </x-paddle-button>

        <p class="mt-5 text-xs text-slate-500">One-time purchase. No subscription.</p>
        <a href="{{ route('shop.cart') }}" class="public-text-link mt-6 inline-block text-sm">Back to cart</a>
    </section>
</x-guest-layout>
