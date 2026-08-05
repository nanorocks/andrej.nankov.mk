<x-guest-layout>
    @php
        $newsletter = \App\Models\Page::getNewsletterPage();

        if (! $newsletter) {
            abort(404, 'Page not found');
        }

        seo(new \RalphJSmit\Laravel\SEO\Support\SEOData(
            title: $newsletter->seo_title ?? 'Subscribe to Andrej Nankov’s Newsletter',
            description: $newsletter->seo_description,
            image: asset('assets/avatars/andrej-nankov-profile.png'),
            author: $newsletter->seo_author ?? 'Andrej Nankov',
            robots: $newsletter->seo_robots,
            url: url()->current(),
            twitter_username: $newsletter->twitter_creator,
        ));
    @endphp

    <section class="public-panel grid gap-10 lg:grid-cols-[minmax(0,1fr)_minmax(20rem,0.8fr)] lg:gap-14" aria-labelledby="newsletter-title">
        <div>
            <div class="flex flex-col items-center gap-6 text-center sm:flex-row sm:text-left">
                <x-profile-photo size="medium" />
                <div>
                    <p class="public-kicker">Monthly ideas worth keeping</p>
                    <p class="mt-2 text-lg font-bold text-white">{{ $newsletter->name }}</p>
                    <p class="mt-1 text-sm text-slate-400">{{ $newsletter->role }}</p>
                </div>
            </div>

            <h1 id="newsletter-title" class="mt-8 public-section-title">{{ $newsletter->headline }}</h1>
            <p class="mt-4 text-lg leading-8 text-slate-300">{{ $newsletter->intro }}</p>

            <div class="public-prose mt-7">
                {!! $newsletter->content !!}
            </div>
        </div>

        <aside class="self-start p-6 border rounded-2xl border-white/10 bg-black/20 sm:p-8" aria-label="Newsletter subscription form">
            <p class="text-xl font-bold text-white">Join the newsletter</p>
            <p class="mt-2 text-sm leading-6 text-slate-400">Useful engineering and startup lessons, delivered without noise.</p>
            @include('newsletter-form')
        </aside>
    </section>
</x-guest-layout>
