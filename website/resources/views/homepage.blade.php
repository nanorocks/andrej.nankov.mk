{{-- filepath: /home/nanorocks/Documents/andrej.nankov.mk/website/resources/views/welcome.blade.php --}}
<x-guest-layout>

    @php
        $homepage = \App\Models\Page::getHomePage();
        if (!$homepage) {
            abort(404, 'Page not found');
        }
    @endphp

    {{-- Feed existing Page SEO fields into the laravel-seo package --}}
    @php
        seo(new \RalphJSmit\Laravel\SEO\Support\SEOData(
            title: $homepage?->seo_title ?? 'Partnering with Startups & Companies | Fractional CTO, Startup Consultant, Senior Engineer',
            description: $homepage?->seo_description,
            image: $homepage?->og_image,
            author: $homepage?->seo_author ?? 'Andrej Nankov',
            robots: $homepage?->seo_robots,
            url: url('/'),
            twitter_username: $homepage?->twitter_creator,
        ));
    @endphp

    <div class="w-full p-6">
        <!-- Card -->
        <div class="card">
            <div class="card-body items-center text-center">

                <!-- Profile Image -->
                <div class="avatar">
                    <div class="w-28 rounded-full ring ring-red-500 ring-offset-0">
                         <img src="{{ asset('storage/' . $homepage?->profile_image) ?? 'https://avatars.githubusercontent.com/u/18250654?v=4' }}"
                        alt="Profile Photo">
                    </div>
                </div>

                <!-- Name + Role -->
                <h2 class="card-title mt-4 text-2xl font-bold">{{ $homepage?->name }}</h2>
                <p class="text-sm opacity-70 mb-2">
                    {{ $homepage?->role }}
                </p>

                <!-- Social Icons -->
                <x-social-icons />

                <!-- Headline -->
                <p class="mt-6 text-lg font-semibold">
                    {{ $homepage?->headline }}
                </p>

                <!-- CTA Button -->
                <div class="card-actions mt-4">
                    <a href="{{ route('get.started') }}" data-pan="Get-Started-Now"
                        class="btn bg-red-500 hover:bg-red-600 text-white rounded-xl border-none">
                        Get Started Now
                    </a>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="mt-6 text-sm leading-relaxed opacity-80 text-left max-w-2xl mx-auto space-y-4">
            <div class="space-y-2 text-center">
                {!! $homepage?->content !!}
            </div>
        </div>
    </div>

    @section('footer')
            <div class="flex justify-center mt-4">
            <a href="https://github.com/sponsors/nanorocks" target="_blank" rel="noopener"
               class="inline-flex items-center px-2 py-1 font-medium rounded-lg shadow transition duration-150 ease-in-out text-sm">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 18l-1.45-1.32C4.4 12.36 2 10.28 2 7.5 2 5.42 3.42 4 5.5 4c1.54 0 3.04.99 3.57 2.36h1.87C11.46 4.99 12.96 4 14.5 4 16.58 4 18 5.42 18 7.5c0 2.78-2.4 4.86-6.55 9.18L10 18z"/>
            </svg>
            Open Source Work
            </a>
        </div>
    @endsection
</x-guest-layout>
