{{-- resources/views/welcome.blade.php --}}
<x-guest-layout>

    {{-- Page SEO --}}
    @section('title', 'Partnering with Startups & Companies | Fractional CTO, Project Consultant, Senior Engineer')
    @section('meta')
        {{-- Standard Meta --}}
        <meta name="description"
            content="I partner with startups and companies to turn complex ideas into reliable, scalable software solutions. Fractional CTO, project consultant, or senior engineer to help you build and scale your next big idea.">
        <meta name="keywords"
            content="Andrej Nankov, Fractional CTO, Startup Consultant, Senior Engineer, Software Solutions, Startups, Scalable Software">
        <meta name="author" content="Andrej Nankov">
        <meta name="robots" content="index, follow">

        {{-- Open Graph / Facebook --}}
        <meta property="og:title"
            content="Partnering with Startups & Companies | Fractional CTO, Project Consultant, Senior Engineer">
        <meta property="og:description"
            content="I partner with startups and companies to turn complex ideas into reliable, scalable software solutions. Fractional CTO, project consultant, or senior engineer to help you build and scale your next big idea.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="https://avatars.githubusercontent.com/u/18250654?v=4">
        <meta property="og:image:alt" content="Andrej Nankov Profile Picture">
        <meta property="og:site_name" content="Andrej Nankov">

        {{-- Twitter --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title"
            content="Partnering with Startups & Companies | Fractional CTO, Project Consultant, Senior Engineer">
        <meta name="twitter:description"
            content="I partner with startups and companies to turn complex ideas into reliable, scalable software solutions. Fractional CTO, project consultant, or senior engineer to help you build and scale your next big idea.">
        <meta name="twitter:image" content="https://avatars.githubusercontent.com/u/18250654?v=4">
        <meta name="twitter:image:alt" content="Andrej Nankov Profile Picture">
        <meta name="twitter:creator" content="@nanorocks">
    @endsection

    <div class="w-full p-6">
        <!-- Card -->
        <div class="card">
            <div class="card-body items-center text-center">

                <!-- Profile Image -->
                <div class="avatar">
                    <div class="w-28 rounded-full ring ring-red-500 ring-offset-0">
                        <img src="https://avatars.githubusercontent.com/u/18250654?v=4" alt="Profile Photo">
                    </div>
                </div>

                <!-- Name + Role -->
                <h2 class="card-title mt-4 text-2xl font-bold">Andrej Nankov</h2>
                <p class="text-sm opacity-70 mb-2">
                    More than just an engineer.
                </p>

                <!-- Social Icons -->
                <div class="flex gap-4 mt-4 justify-center">
                    <a target="_blank" href="https://www.linkedin.com/in/nanorocks/"
                        class="btn btn-circle btn-outline btn-sm transition-all duration-200 hover:text-white text-gray-400 border-gray-400 hover:border-white"
                        title="LinkedIn">
                        <i data-feather="linkedin" class="w-5 h-5"></i>
                    </a>
                    <a target="_blank" href="https://medium.com/nanorocks"
                        class="btn btn-circle btn-outline btn-sm transition-all duration-200 hover:text-white text-gray-400 border-gray-400 hover:border-white"
                        title="Medium" rel="noopener">
                        <i data-feather="book-open" class="w-5 h-5"></i>
                    </a>
                    <a target="_blank" href="https://www.youtube.com/@nanorocks"
                        class="btn btn-circle btn-outline btn-sm transition-all duration-200 hover:text-white text-gray-400 border-gray-400 hover:border-white"
                        title="YouTube">
                        <i data-feather="youtube" class="w-5 h-5"></i>
                    </a>
                    <a target="_blank" href="https://github.com/nanorocks"
                        class="btn btn-circle btn-outline btn-sm transition-all duration-200 hover:text-white text-gray-400 border-gray-400 hover:border-white"
                        title="GitHub">
                        <i data-feather="github" class="w-5 h-5"></i>
                    </a>
                    <a target="_blank" href="https://www.facebook.com/nanorocks"
                        class="btn btn-circle btn-outline btn-sm transition-all duration-200 hover:text-white text-gray-400 border-gray-400 hover:border-white"
                        title="Facebook">
                        <i data-feather="facebook" class="w-5 h-5"></i>
                    </a>
                </div>

                <!-- Headline -->
                <p class="mt-6 text-lg font-semibold">
                    Helping founders and companies get started with their software ideas 🚀
                </p>

                <!-- CTA Button -->
                <div class="card-actions mt-4">
                    <a href="{{ route('get.started') }}"
                        class="btn bg-red-500 hover:bg-red-600 text-white rounded-xl border-none">
                        Get Started Now
                    </a>
                </div>

                <!-- Description -->
                <div class="mt-6 text-sm leading-relaxed opacity-80 text-left max-w-2xl mx-auto space-y-4">
                    <div class="space-y-2 text-justify">
                        <p>
                            I partner with startups and companies to turn complex ideas into reliable,
                            scalable software solutions.
                        </p>
                        <p>
                            Let’s connect if you’re looking for a <span class="font-semibold">fractional CTO</span>,
                            project consultant, or a senior engineer to help you build and
                            scale your next big idea.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="py-16 text-center text-sm text-gray-400 dark:text-white/70">
        Release v{{ Illuminate\Foundation\Application::VERSION }} -
        Environment v{{ PHP_VERSION }}
    </footer>
</x-guest-layout>
