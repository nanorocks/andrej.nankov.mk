{{-- resources/views/about-me.blade.php --}}
<x-guest-layout>
    @php
        $about = \App\Models\Page::getAboutPage();
        if (!$about) {
            abort(404, 'Page not found');
        }
    @endphp
    {{-- SEO --}}
    @section('title', 'About')
    @section('meta')
        <meta name="description" content="{{ $about?->seo_description }}">
        <meta name="keywords" content="{{ $about?->seo_keywords }}">
        <meta name="author" content="{{ $about?->seo_author }}">
        <meta name="robots" content="{{ $about?->seo_robots }}">

        <meta property="og:title" content="{{ $about?->og_title }}">
        <meta property="og:description" content="{{ $about?->og_description }}">
        <meta property="og:type" content="{{ $about?->og_type }}">
        <meta property="og:url" content="{{ $about?->og_url ?? url()->current() }}">
        <meta property="og:image" content="{{ $about?->og_image }}">
        <meta property="og:image:alt" content="{{ $about?->og_image_alt }}">
        <meta property="og:site_name" content="{{ $about?->og_site_name }}">

        <meta name="twitter:card" content="{{ $about?->twitter_card }}">
        <meta name="twitter:title" content="{{ $about?->twitter_title }}">
        <meta name="twitter:description" content="{{ $about?->twitter_description }}">
        <meta name="twitter:image" content="{{ $about?->twitter_image }}">
        <meta name="twitter:image:alt" content="{{ $about?->twitter_image_alt }}">
        <meta name="twitter:creator" content="{{ $about?->twitter_creator }}">
    @endsection

    <div class="card">
        <div class="card-body items-center text-center">

            <div class="avatar mb-6">
                <div class="w-28 rounded-full ring ring-red-500 ring-offset-0">
                    <img src="{{ asset('storage/' . $about?->profile_image) ?? 'https://avatars.githubusercontent.com/u/18250654?v=4' }}"
                        alt="Profile Photo">
                </div>
            </div>
            <h2 class="text-2xl font-semibold mb-2">{{ $about?->name }}</h2>
            <p class="text-lg text-gray-400 mb-4">{{ $about?->title }}</p>
            <div class="space-y-6 text-base leading-relaxed text-left max-w-2xl mx-auto text-justify">
                {!! $about?->content !!}
                <div class="mt-10 flex justify-center">
                    <a href="{{ $about?->cv_url }}" target="_blank" data-pan="Grab-CV"
                        class="inline-flex items-center px-6 py-3 bg-red-500 text-white font-semibold rounded-lg shadow hover:bg-red-600 transition-colors duration-200">
                        <i data-feather="download" class="mr-2"></i>
                        Grab My CV
                    </a>
                </div>
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

    </div>
</x-guest-layout>
