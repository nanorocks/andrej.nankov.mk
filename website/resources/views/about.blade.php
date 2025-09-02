{{-- resources/views/about-me.blade.php --}}
<x-guest-layout>

    {{-- SEO --}}
    @section('title', 'About')
    @section('meta')
        {{-- Standard Meta --}}
        <meta name="description"
            content="Learn about Andrej Nankov, a Software Engineer with 7+ years of experience in FinTech, E-commerce, Telecommunications, and Digital Transformation.">
        <meta name="keywords"
            content="Andrej Nankov, Software Engineer, Technical Consultant, Full Stack Developer, FinTech, E-commerce, Digital Transformation">
        <meta name="author" content="Andrej Nankov">
        <meta name="robots" content="index, follow">

        {{-- Open Graph / Facebook --}}
        <meta property="og:title" content="About Andrej Nankov">
        <meta property="og:description"
            content="Learn about Andrej Nankov, a Software Engineer with 7+ years of experience in FinTech, E-commerce, Telecommunications, and Digital Transformation.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="https://avatars.githubusercontent.com/u/18250654?v=4">
        <meta property="og:image:alt" content="Andrej Nankov Profile Picture">
        <meta property="og:site_name" content="Andrej Nankov">

        {{-- Twitter --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="About Andrej Nankov">
        <meta name="twitter:description"
            content="Learn about Andrej Nankov, a Software Engineer with 7+ years of experience in FinTech, E-commerce, Telecommunications, and Digital Transformation.">
        <meta name="twitter:image" content="https://avatars.githubusercontent.com/u/18250654?v=4">
        <meta name="twitter:image:alt" content="Andrej Nankov Profile Picture">
        <meta name="twitter:creator" content="@nanorocks">
    @endsection

    <div class="card">
        <div class="card-body items-center text-center">

            @php
                $about = \App\Models\AboutPage::first();
            @endphp

            <div class="avatar mb-6">
                <div class="w-28 rounded-full ring ring-red-500 ring-offset-0">
                    <img src="{{ asset('storage/' . $about?->profile_image) }}" alt="Profile Photo">
                </div>
            </div>
            <h2 class="text-2xl font-semibold mb-2">{{ $about?->name }}</h2>
            <p class="text-lg text-gray-400 mb-4">{{ $about?->title }}</p>
            <div class="space-y-6 text-base leading-relaxed text-left max-w-2xl mx-auto text-justify">
                {!! $about?->about_content !!}
                <div class="mt-10 flex justify-center">
                    <a href="{{ $about?->cv_url }}" target="_blank"
                        class="inline-flex items-center px-6 py-3 bg-red-500 text-white font-semibold rounded-lg shadow hover:bg-red-600 transition-colors duration-200">
                        <i data-feather="download" class="mr-2"></i>
                        Grab My CV
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

    </div>
</x-guest-layout>
