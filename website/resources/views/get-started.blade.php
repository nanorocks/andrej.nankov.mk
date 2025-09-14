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

    <footer class="py-16 text-center text-sm text-grey dark:text-white/70">
        Release v{{ Illuminate\Foundation\Application::VERSION }} -
        Environment v{{ PHP_VERSION }}

        <br />

        {{-- Social Icons --}}
        <x-social-icons />
    </footer>

</x-guest-layout>
