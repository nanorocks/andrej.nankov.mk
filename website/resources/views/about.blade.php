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

    <div class="w-full p-6">
        <div class="card">
            <div class="card-body items-center text-center">

                {{-- Profile Image --}}
                <div class="avatar mb-6">
                    <div class="w-28 rounded-full ring ring-red-500 ring-offset-0">
                        <img src="https://avatars.githubusercontent.com/u/18250654?v=4" alt="Profile Photo">
                    </div>
                </div>

                {{-- Name & Title --}}
                <h2 class="text-2xl font-semibold mb-2">Andrej Nankov</h2>
                <p class="text-lg text-gray-400 mb-4">Software Engineer | M.Sc. | YOE +7</p>

                {{-- About Me Content --}}
                <div class="space-y-6 text-base leading-relaxed text-left max-w-2xl mx-auto text-justify">
                    <ul class="list list-inside mb-4">
                        <li>
                            My work is guided by <span class="font-semibold text-red-400">Discipline</span>,
                            <span class="font-semibold text-red-400">Passion</span>, and
                            <span class="font-semibold text-red-400">Focus</span>.
                        </li>
                    </ul>

                    <p>
                        I partner with startups and companies to turn complex ideas into reliable, scalable
                        software solutions. With over 7 years of hands-on experience in <span class="font-semibold">FinTech,
                        E-commerce, Telecommunications, and Digital Transformation</span>, I bring a mix of technical expertise and strategic guidance to every project.
                    </p>

                    <p>
                        I specialize in <span class="font-semibold">technical consulting, system architecture, and hands-on development</span>. From planning and design to deployment and optimization, I help teams make the right decisions early, avoid costly mistakes, and deliver software that truly works for their business.
                    </p>

                    <p>
                        My expertise spans both frontend and backend development, with experience across the JavaScript, PHP, and Java ecosystems. I enjoy creating clean, efficient code, implementing best practices like SOLID principles and design patterns, and mentoring teams to grow.
                    </p>

                    <p>
                        Beyond client work, I share knowledge through writing, blogging, and content creation about software engineering, finance, and technology trends. I’m also passionate about exploring new places and documenting my travels through video content.
                    </p>

                    <div class="mt-8 text-lg font-medium text-red-400 flex items-center gap-2">
                        🚀 If you’re looking for a fractional CTO, project consultant, or a senior engineer,
                        I’d love to collaborate on turning your vision into reality.
                    </div>

                    {{-- CV Button --}}
                    <div class="mt-10 flex justify-center">
                        <a href="https://bit.ly/4lJ7bJG" target="_blank"
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

        </div>
    </div>

</x-guest-layout>
