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

            {{-- Profile Image --}}
            <div class="avatar">
                <div class="w-28 rounded-full ring ring-red-500 ring-offset-0">
                    <img src="https://avatars.githubusercontent.com/u/18250654?v=4" alt="Profile Photo">
                </div>
            </div>

            {{-- Name + Role --}}
            <h2 class="card-title mt-4 text-2xl font-bold">Andrej Nankov</h2>
            <p class="text-sm opacity-70">More than just an engineer.</p>

            {{-- Newsletter Headline --}}
            <h2 class="mt-8 text-xl font-bold text-red-500">Subscribe to my Newsletter</h2>
            <p class="mt-2 text-sm opacity-80">
                Get the latest updates, articles, and insights directly to your inbox. No spam, ever.
            </p>
            <div class="mt-4 text-left max-w-xl mx-auto text-base opacity-90 text-justify">
                <p>Join a growing community of founders, engineers, and tech enthusiasts who receive my curated
                    newsletter every month. I share actionable advice, deep dives into software engineering,
                    entrepreneurship stories, and exclusive resources you won't find anywhere else.</p>
                <ul class="list-disc ml-6 mt-2">
                    <li>Fresh articles on building and scaling software products</li>
                    <li>Behind-the-scenes lessons from my own startup journey</li>
                    <li>Tips for navigating the tech industry and career growth</li>
                    <li>Early access to new tools, guides, and events</li>
                    <li>Occasional personal stories and reflections</li>
                </ul>
                <p class="mt-2">Whether you're a founder, developer, or just passionate about technology, this
                    newsletter is designed to inspire and inform. I respect your inbox - no spam, just quality
                    content.</p>
                <p class="mt-2 font-semibold text-red-400">Enter your email below to join!</p>
            </div>

            {{-- Newsletter Form --}}
            @include('newsletter-form')
        </div>
    </div>


    <footer class="py-16 text-center text-sm text-grey dark:text-white/70">
        Release v{{ Illuminate\Foundation\Application::VERSION }} - Environment v{{ PHP_VERSION }}
        <br />
        {{-- Social Icons --}}
        <div class="flex gap-4 mt-4 justify-center">
            <a target="_blank" href="https://www.linkedin.com/in/nanorocks/"
                class="btn btn-circle btn-outline btn-sm hover:text-white text-gray-400 border-gray-400 hover:border-white"
                title="LinkedIn"><i data-feather="linkedin" class="w-5 h-5"></i></a>
            <a target="_blank" href="https://medium.com/nanorocks"
                class="btn btn-circle btn-outline btn-sm hover:text-white text-gray-400 border-gray-400 hover:border-white"
                title="Medium" rel="noopener"><i data-feather="book-open" class="w-5 h-5"></i></a>
            <a target="_blank" href="https://www.youtube.com/@nanorocks"
                class="btn btn-circle btn-outline btn-sm hover:text-white text-gray-400 border-gray-400 hover:border-white"
                title="YouTube"><i data-feather="youtube" class="w-5 h-5"></i></a>
            <a target="_blank" href="https://github.com/nanorocks"
                class="btn btn-circle btn-outline btn-sm hover:text-white text-gray-400 border-gray-400 hover:border-white"
                title="GitHub"><i data-feather="github" class="w-5 h-5"></i></a>
            <a target="_blank" href="https://www.facebook.com/nanorocks"
                class="btn btn-circle btn-outline btn-sm hover:text-white text-gray-400 border-gray-400 hover:border-white"
                title="Facebook"><i data-feather="facebook" class="w-5 h-5"></i></a>
        </div>
    </footer>

</x-guest-layout>
