<x-guest-layout>
    @php
        $homepage = \App\Models\Page::getHomePage();

        if (! $homepage) {
            abort(404, 'Page not found');
        }

        seo(new \RalphJSmit\Laravel\SEO\Support\SEOData(
            title: $homepage->seo_title ?? 'Partnering with Startups & Companies | Andrej Nankov',
            description: $homepage->seo_description,
            image: asset('assets/avatars/andrej-nankov-profile.png'),
            author: $homepage->seo_author ?? 'Andrej Nankov',
            robots: $homepage->seo_robots,
            url: url('/'),
            twitter_username: $homepage->twitter_creator,
        ));
    @endphp

    <section class="public-panel grid items-center gap-10 lg:grid-cols-[minmax(0,1fr)_auto] lg:gap-16" aria-labelledby="home-title">
        <div class="order-2 text-center lg:order-1 lg:text-left">
            <p class="public-kicker">{{ $homepage->role }}</p>
            <h1 id="home-title" class="public-title">{{ $homepage->headline }}</h1>

            <div class="public-prose mt-7 lg:max-w-2xl">
                {!! $homepage->content !!}
            </div>

            <div class="flex flex-col justify-center gap-3 mt-8 sm:flex-row lg:justify-start">
                <a href="{{ route('get.started') }}" data-pan="Get-Started-Now" class="public-button-primary">
                    Start a conversation
                </a>
                <a href="{{ route('about') }}" class="public-button-secondary">More about me</a>
            </div>
        </div>

        <div class="flex flex-col items-center order-1 lg:order-2">
            <x-profile-photo priority />
            <p class="mt-5 text-lg font-bold text-white">{{ $homepage->name }}</p>
            <p class="mt-1 text-sm text-slate-400">Fractional CTO &amp; Senior Engineer</p>
        </div>
    </section>
</x-guest-layout>
