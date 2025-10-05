{{-- filepath: /home/nanorocks/Documents/andrej.nankov.mk/website/resources/views/get-started.blade.php --}}
<x-guest-layout>

    @php
        $getStarted = \App\Models\Page::where('flag', 'get-started')->where('is_published', true)->first();
        if (!$getStarted) {
            abort(404, 'Page not found');
        }
    @endphp

    {{-- SEO --}}
    @section('title', $getStarted?->seo_title ?? 'Get Started With Your Startup Idea')
    @section('meta')
        <meta name="description" content="{{ $getStarted?->seo_description }}">
        <meta name="keywords" content="{{ $getStarted?->seo_keywords }}">
        <meta name="author" content="{{ $getStarted?->seo_author }}">
        <meta name="robots" content="{{ $getStarted?->seo_robots }}">

        <meta property="og:title" content="{{ $getStarted?->og_title }}">
        <meta property="og:description" content="{{ $getStarted?->og_description }}">
        <meta property="og:type" content="{{ $getStarted?->og_type }}">
        <meta property="og:url" content="{{ $getStarted?->og_url ?? url()->current() }}">
        <meta property="og:image" content="{{ $getStarted?->og_image }}">
        <meta property="og:image:alt" content="{{ $getStarted?->og_image_alt }}">
        <meta property="og:site_name" content="{{ $getStarted?->og_site_name }}">

        <meta name="twitter:card" content="{{ $getStarted?->twitter_card }}">
        <meta name="twitter:title" content="{{ $getStarted?->twitter_title }}">
        <meta name="twitter:description" content="{{ $getStarted?->twitter_description }}">
        <meta name="twitter:image" content="{{ $getStarted?->twitter_image }}">
        <meta name="twitter:image:alt" content="{{ $getStarted?->twitter_image_alt }}">
        <meta name="twitter:creator" content="{{ $getStarted?->twitter_creator }}">
    @endsection

    <div class="card">
        <div class="card-body items-center text-center">

            {{-- Banner Title --}}
            <h2 class="card-title text-2xl font-bold text-red-500">
                {{ $getStarted?->headline }}
            </h2>

            {{-- Headline --}}
            <p class="mt-4 text-lg font-semibold text-white">
                {{ $getStarted?->intro }}
            </p>

            {{-- Motivational Points & Main Content --}}
            <div class="mt-6 text-left space-y-3 text-gray-300 leading-relaxed">
                {!! $getStarted?->content !!}
            </div>

            {{-- CTA Button --}}
            <div class="mt-6 text-gray-200">
                <a href="https://calendly.com/nanorocks/30min" data-pan="Book-Free-Call"
                    class="btn bg-red-500 hover:bg-red-600 text-white rounded-xl border-none text-lg font-semibold px-6">
                    Book A Free Call To Get Started
                </a>
            </div>

        </div>
    </div>

    @section('footer')

     <br />

        {{-- Social Icons --}}
        <x-social-icons />

        <div class="flex justify-center mt-4">
            <a href="https://github.com/sponsors/nanorocks" target="_blank" rel="noopener"
               class="inline-flex items-center px-2 py-1  font-medium rounded-lg shadow transition duration-150 ease-in-out text-sm">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 18l-1.45-1.32C4.4 12.36 2 10.28 2 7.5 2 5.42 3.42 4 5.5 4c1.54 0 3.04.99 3.57 2.36h1.87C11.46 4.99 12.96 4 14.5 4 16.58 4 18 5.42 18 7.5c0 2.78-2.4 4.86-6.55 9.18L10 18z"/>
            </svg>
            Open Source Work
            </a>
        </div>
    @endsection
</x-guest-layout>
