<div class="flex flex-wrap items-center justify-center gap-2">
    <a href="{{ route('home') }}"
        class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20]">
        Home
    </a>
    <a href="{{ route('about') }}"
        class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20]">
        About
    </a>
    <a href="https://medium.com/@nanorocks" target="_blank" rel="noopener"
        class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20]">
        Blog
    </a>
    <a href="{{ route('newsletter') }}"
        class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20]">
        Newsletter
    </a>
    <a href="{{ route('get.started') }}"
        class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20]">
        Get Started
    </a>
    <a href="mailto:andrejnankov@gmail.com"
        class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20]">
        Contact
    </a>
    <a href="https://support.nankov.mk" target="_blank" rel="noopener"
        class="rounded-md px-3 py-2 text-red-500 ring-1 ring-transparent transition hover:text-red-500/70 focus:outline-none focus-visible:ring-[#FF2D20]">
        Support Center
    </a>

    @auth
        <a href="{{ url('/admin') }}"
            class="rounded-md px-3 py-2 text-red-500 ring-1 ring-transparent transition hover:text-red-500/70 focus:outline-none focus-visible:ring-[#FF2D20] flex items-center gap-2"
            title="Admin">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                <polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
            Admin
        </a>
    @endauth
</div>
