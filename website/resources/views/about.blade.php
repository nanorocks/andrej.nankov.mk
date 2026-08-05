<x-guest-layout>
    @php
        $about = \App\Models\Page::getAboutPage();

        if (! $about) {
            abort(404, 'Page not found');
        }

        seo(new \RalphJSmit\Laravel\SEO\Support\SEOData(
            title: $about->seo_title ?? 'About Andrej Nankov',
            description: $about->seo_description,
            image: asset('assets/avatars/andrej-nankov-profile.png'),
            author: $about->seo_author ?? 'Andrej Nankov',
            robots: $about->seo_robots,
            url: url()->current(),
            twitter_username: $about->twitter_creator,
        ));
    @endphp

    <article class="public-panel" aria-labelledby="about-title">
        <div class="grid items-center gap-8 border-b border-white/10 pb-10 sm:grid-cols-[auto_minmax(0,1fr)] sm:gap-10">
            <x-profile-photo />

            <div class="text-center sm:text-left">
                <p class="public-kicker">About</p>
                <h1 id="about-title" class="mt-3 public-section-title">{{ $about->name }}</h1>
                <p class="mt-3 text-lg text-slate-300">{{ $about->title }}</p>
            </div>
        </div>

        <div class="max-w-3xl mx-auto mt-10 public-prose">
            {!! $about->content !!}
        </div>

        @if ($about->cv_url)
            <div class="flex justify-center mt-10">
                <a href="{{ $about->cv_url }}" target="_blank" rel="noopener noreferrer" data-pan="Grab-CV" class="gap-2 public-button-primary">
                    <svg class="w-4 h-4 stroke-current fill-none" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 3v12m0 0 5-5m-5 5-5-5M5 20h14" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Download my CV
                </a>
            </div>
        @endif
    </article>
</x-guest-layout>
