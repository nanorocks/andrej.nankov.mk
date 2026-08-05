<x-guest-layout>
    <section class="public-panel mx-auto max-w-3xl text-center" aria-labelledby="success-title">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full border border-emerald-400/30 bg-emerald-500/10 text-2xl text-emerald-300" aria-hidden="true">✓</div>
        <p class="public-kicker mt-7">Order #{{ $order->id }}</p>
        <h1 id="success-title" class="public-section-title mt-3">Thanks for your order</h1>

        @if ($order->isCompleted())
            <p class="mx-auto mt-4 max-w-xl leading-7 text-slate-300">Payment is confirmed. Any e-books in this order are now available from your profile.</p>
        @else
            <p class="mx-auto mt-4 max-w-xl leading-7 text-slate-300">Paddle is confirming your payment. Downloads will appear in your profile as soon as the signed webhook arrives.</p>
        @endif

        <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ route('profile') }}" class="public-button-primary">Go to my downloads</a>
            <a href="{{ route('shop.index') }}" class="public-button-secondary">Return to shop</a>
        </div>
    </section>
</x-guest-layout>
