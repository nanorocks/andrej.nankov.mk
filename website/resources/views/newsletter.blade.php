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


    @section('footer')

        {{-- Social Icons --}}
        <x-social-icons />

        <div class="flex justify-center mt-4">
            <a href="https://github.com/sponsors/nanorocks" target="_blank" rel="noopener"
                class="inline-flex items-center px-2 py-1  font-medium rounded-lg shadow transition duration-150 ease-in-out text-sm">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 18l-1.45-1.32C4.4 12.36 2 10.28 2 7.5 2 5.42 3.42 4 5.5 4c1.54 0 3.04.99 3.57 2.36h1.87C11.46 4.99 12.96 4 14.5 4 16.58 4 18 5.42 18 7.5c0 2.78-2.4 4.86-6.55 9.18L10 18z" />
                </svg>
                Open Source Work
            </a>
        </div>
    @endsection

</x-guest-layout>
