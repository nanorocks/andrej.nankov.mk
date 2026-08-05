<x-guest-layout>
    @php
        $getStarted = \App\Models\Page::where('flag', 'get-started')->where('is_published', true)->first();

        if (! $getStarted) {
            abort(404, 'Page not found');
        }

        seo(new \RalphJSmit\Laravel\SEO\Support\SEOData(
            title: $getStarted->seo_title ?? 'Get Started With Your Startup Idea',
            description: $getStarted->seo_description,
            image: asset('assets/avatars/andrej-nankov-profile.png'),
            author: $getStarted->seo_author ?? 'Andrej Nankov',
            robots: $getStarted->seo_robots,
            url: url()->current(),
            twitter_username: $getStarted->twitter_creator,
        ));
    @endphp

    <section class="public-panel text-center" aria-labelledby="get-started-title">
        <div class="mx-auto max-w-3xl">
            <p class="public-kicker">From idea to a clear next step</p>
            <h1 id="get-started-title" class="public-title">{{ $getStarted->headline }}</h1>
            <p class="public-lead">{{ $getStarted->intro }}</p>
        </div>

        <div class="public-prose mx-auto mt-10 max-w-3xl text-left">
            {!! $getStarted->content !!}
        </div>

        <div class="mt-10 flex flex-col items-center gap-3">
            <a href="https://calendly.com/nanorocks/30min" target="_blank" rel="noopener noreferrer" data-pan="Book-Free-Call" class="public-button-primary px-7 py-4 text-base">
                Book a free 30-minute call
            </a>
            <p class="text-sm text-slate-500">No sales pitch. Just practical, honest guidance.</p>
        </div>
    </section>
</x-guest-layout>
