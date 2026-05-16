<x-guest-layout>
    @php
        seo(new \RalphJSmit\Laravel\SEO\Support\SEOData(
            title: "You're offline — Andrej Nankov",
            description: 'No internet connection. Check your network and try again.',
            robots: 'noindex,nofollow',
        ));
    @endphp

    <div class="flex flex-col items-center justify-center min-h-[60vh] text-center px-6">
        <div class="text-6xl mb-6">📡</div>
        <h1 class="text-2xl font-bold text-white mb-3">You're offline</h1>
        <p class="text-white/60 mb-8 max-w-md">
            It looks like you've lost your internet connection.
            Some pages are cached and may still be available.
        </p>
        <button
            onclick="window.location.reload()"
            class="btn btn-primary">
            Try again
        </button>
    </div>
</x-guest-layout>
