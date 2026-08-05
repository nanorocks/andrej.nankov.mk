<x-guest-layout>
    @php
        seo(new \RalphJSmit\Laravel\SEO\Support\SEOData(
            title: "You're offline — Andrej Nankov",
            description: 'No internet connection. Check your network and try again.',
            robots: 'noindex,nofollow',
        ));
    @endphp

    <section class="public-panel mx-auto max-w-2xl text-center" aria-labelledby="offline-title">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-3xl" aria-hidden="true">📡</div>
        <p class="public-kicker mt-7">Connection interrupted</p>
        <h1 id="offline-title" class="public-section-title mt-3">You're offline</h1>
        <p class="mx-auto mt-4 max-w-md text-base leading-7 text-slate-400">
            Check your connection and try again. Previously visited pages may still be available from the local cache.
        </p>
        <button type="button" onclick="window.location.reload()" class="public-button-primary mt-8">Try again</button>
    </section>
</x-guest-layout>
