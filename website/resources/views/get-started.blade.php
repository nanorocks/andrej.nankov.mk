{{-- resources/views/get-started.blade.php --}}
<x-guest-layout>

    {{-- SEO --}}
    @section('title', 'Get Started With Your Startup Idea')
    @section('meta')
        {{-- Standard Meta --}}
        <meta name="description"
            content="Get started with your startup idea! Book a free call with Andrej Nankov to validate your idea, get technical guidance, and receive actionable advice tailored to your startup journey.">
        <meta name="keywords"
            content="Andrej Nankov, Get Started, Startup Idea, Free Call, CTO, Technical Guidance, Entrepreneurship, Software Engineering">
        <meta name="author" content="Andrej Nankov">
        <meta name="robots" content="index, follow">

        {{-- Open Graph / Facebook --}}
        <meta property="og:title" content="Get Started With Your Startup Idea">
        <meta property="og:description"
            content="Book a free call with Andrej Nankov to validate your startup idea, get technical guidance, and actionable advice tailored to your journey.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="https://avatars.githubusercontent.com/u/18250654?v=4">
        <meta property="og:image:alt" content="Andrej Nankov Profile Picture">
        <meta property="og:site_name" content="Andrej Nankov">

        {{-- Twitter --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Get Started With Your Startup Idea">
        <meta name="twitter:description"
            content="Book a free call with Andrej Nankov to validate your startup idea, get technical guidance, and actionable advice tailored to your journey.">
        <meta name="twitter:image" content="https://avatars.githubusercontent.com/u/18250654?v=4">
        <meta name="twitter:image:alt" content="Andrej Nankov Profile Picture">
        <meta name="twitter:creator" content="@nanorocks">
    @endsection


    <div class="card">
        <div class="card-body items-center text-center">

            {{-- Banner Title --}}
            <h2 class="card-title text-2xl font-bold text-red-500">
                Get Started With Your Startup Idea!
            </h2>

            {{-- Headline --}}
            <p class="mt-4 text-lg font-semibold">
                Have an idea but don’t know how to begin? 🚀
            </p>

            {{-- Motivational Points --}}
            <div class="mt-6 text-left space-y-3 text-gray-300 leading-relaxed">
                <p>✔️ Not sure if your idea will work or how to validate it before you commit?</p>
                <p>✔️ You’re not a software engineer and need someone technical to guide you.</p>
                <p>✔️ You want a clear, actionable plan you can follow to move forward.</p>
                <p>✔️ You’re looking for feedback and someone to bounce ideas with.</p>
            </div>

            {{-- Imagine --}}
            <div class="mt-6 text-gray-200 italic">
                Imagine having a clear, actionable plan on how to move forward with your idea.
            </div>

            {{-- How it Works --}}
            <div class="mt-8 text-center bg-base rounded-xl p-6 shadow-md">
                <h3 class="text-lg font-semibold text-red-400 mb-3">Here’s How It Works</h3>
                <p class="text-gray-300">
                    Book a <span class="font-bold">FREE call</span> with me to talk about your idea.
                    I’ll help you get started on your journey with practical, actionable advice
                    tailored to your situation.
                </p>
            </div>

            {{-- CTA Button --}}
            <div class="card-actions mt-8 flex justify-center">
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
