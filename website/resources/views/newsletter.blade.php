{{-- resources/views/newsletter.blade.php --}}
<x-guest-layout>

    {{-- SEO --}}

    @php
        $newsletter = \App\Models\Page::getNewsletterPage();
        if (!$newsletter) {
            abort(404, 'Page not found');
        }
    @endphp

    @section('title', $newsletter?->seo_title ?? 'Subscribe to Newsletter')
    @section('meta')
        <meta name="description" content="{{ $newsletter?->seo_description }}">
        <meta name="keywords" content="{{ $newsletter?->seo_keywords }}">
        <meta name="author" content="{{ $newsletter?->seo_author }}">
        <meta name="robots" content="{{ $newsletter?->seo_robots }}">

        <meta property="og:title" content="{{ $newsletter?->og_title }}">
        <meta property="og:description" content="{{ $newsletter?->og_description }}">
        <meta property="og:type" content="{{ $newsletter?->og_type }}">
        <meta property="og:url" content="{{ $newsletter?->og_url ?? url()->current() }}">
        <meta property="og:image" content="{{ $newsletter?->og_image }}">
        <meta property="og:image:alt" content="{{ $newsletter?->og_image_alt }}">
        <meta property="og:site_name" content="{{ $newsletter?->og_site_name }}">

        <meta name="twitter:card" content="{{ $newsletter?->twitter_card }}">
        <meta name="twitter:title" content="{{ $newsletter?->twitter_title }}">
        <meta name="twitter:description" content="{{ $newsletter?->twitter_description }}">
        <meta name="twitter:image" content="{{ $newsletter?->twitter_image }}">
        <meta name="twitter:image:alt" content="{{ $newsletter?->twitter_image_alt }}">
        <meta name="twitter:creator" content="{{ $newsletter?->twitter_creator }}">
    @endsection

    <div class="card">
        <div class="card-body items-center text-center">
            <div class="avatar">
                <div class="w-28 rounded-full ring ring-red-500 ring-offset-0">
                    <img src="{{ asset('storage/' . $newsletter?->profile_image) ?? 'https://avatars.githubusercontent.com/u/18250654?v=4' }}"
                        alt="Profile Photo">
                </div>
            </div>
            <h2 class="card-title mt-4 text-2xl font-bold">{{ $newsletter?->name }}</h2>
            <p class="text-sm opacity-70">{{ $newsletter?->role }}</p>
            <h2 class="mt-8 text-xl font-bold text-red-500">{{ $newsletter?->headline }}</h2>
            <p class="mt-2 text-sm opacity-80">
                {{ $newsletter?->intro }}
            </p>
            <div class="mt-4 text-left max-w-xl mx-auto text-base opacity-90 text-justify">
                {!! $newsletter?->content !!}
            </div>
            @include('newsletter-form')
        </div>
    </div>


    <footer class="py-16 text-center text-sm text-grey dark:text-white/70">
        Release v{{ Illuminate\Foundation\Application::VERSION }} - Environment v{{ PHP_VERSION }}
        <br />
        {{-- Social Icons --}}
         <x-social-icons />
    </footer>

</x-guest-layout>
