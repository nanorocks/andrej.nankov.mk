{{-- resources/views/newsletter.blade.php --}}
<x-guest-layout>

    {{-- SEO --}}
    @section('title', 'Subscribe to Newsletter')
    @section('meta')
        {{-- Standard Meta --}}
        <meta name="description"
            content="Join Andrej Nankov's newsletter for founders, engineers, and tech enthusiasts. Get updates, articles, insights, and exclusive resources on software engineering and entrepreneurship. No spam.">
        <meta name="keywords"
            content="Andrej Nankov, Newsletter, Software Engineering, Entrepreneurship, Tech Updates, Startups">
        <meta name="author" content="Andrej Nankov">
        <meta name="robots" content="index, follow">

        {{-- Open Graph / Facebook --}}
        <meta property="og:title" content="Subscribe to Newsletter">
        <meta property="og:description"
            content="Join Andrej Nankov's newsletter for founders, engineers, and tech enthusiasts. Get updates, articles, insights, and exclusive resources on software engineering and entrepreneurship. No spam.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="https://avatars.githubusercontent.com/u/18250654?v=4">
        <meta property="og:image:alt" content="Andrej Nankov Profile Picture">
        <meta property="og:site_name" content="Andrej Nankov">

        {{-- Twitter --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Subscribe to Newsletter">
        <meta name="twitter:description"
            content="Join Andrej Nankov's newsletter for founders, engineers, and tech enthusiasts. Get updates, articles, insights, and exclusive resources on software engineering and entrepreneurship. No spam.">
        <meta name="twitter:image" content="https://avatars.githubusercontent.com/u/18250654?v=4">
        <meta name="twitter:image:alt" content="Andrej Nankov Profile Picture">
        <meta name="twitter:creator" content="@nanorocks">
    @endsection


    <div class="card">
        <div class="card-body items-center text-center">

            @php
                $newsletter = \App\Models\NewsletterPage::first();
            @endphp

            {{-- Profile Image --}}
            <div class="avatar">
                <div class="w-28 rounded-full ring ring-red-500 ring-offset-0">
                    <img src="{{ $newsletter?->profile_image_url ?? 'https://avatars.githubusercontent.com/u/18250654?v=4' }}" alt="Profile Photo">
                </div>
            </div>

            {{-- Name + Role --}}
            <h2 class="card-title mt-4 text-2xl font-bold">{{ $newsletter?->name }}</h2>
            <p class="text-sm opacity-70">{{ $newsletter?->role }}</p>

            {{-- Newsletter Headline --}}
            <h2 class="mt-8 text-xl font-bold text-red-500">{{ $newsletter?->headline }}</h2>
            <p class="mt-2 text-sm opacity-80">
                {{ $newsletter?->intro }}
            </p>
            <div class="mt-4 text-left max-w-xl mx-auto text-base opacity-90 text-justify">
                {!! $newsletter?->main_content !!}
            </div>

            {{-- Newsletter Form --}}
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
