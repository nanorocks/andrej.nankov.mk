<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-[#090b0e]">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">

    <meta name="theme-color" content="#090b0e">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">

    {!! seo() !!}

    @if (env('GOOGLE_SITE_VERIFICATION'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GOOGLE_SITE_VERIFICATION') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());
            gtag('config', '{{ env('GOOGLE_SITE_VERIFICATION') }}');
        </script>
    @endif

    @if (config('services.google_analytics.id') && app()->isProduction())
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google_analytics.id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());
            gtag('config', '{{ config('services.google_analytics.id') }}');
        </script>
    @endif

    @stack('meta')

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>

<body class="public-site min-h-screen bg-[#090b0e] font-sans text-slate-100 antialiased">
    <a href="#main-content" class="public-skip-link">Skip to content</a>

    <div class="public-background" aria-hidden="true"></div>

    <div class="relative isolate flex min-h-screen flex-col">
        <header class="public-header">
            <div class="public-container flex items-center justify-between gap-6 py-5">
                <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-lg focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-red-500" aria-label="Andrej Nankov — Home">
                    <span class="public-brand-mark" aria-hidden="true">
                        <img src="{{ asset('assets/avatars/personal_logo_notes_nankov.png') }}" alt="" width="48" height="48">
                    </span>
                    <span class="text-sm font-bold tracking-wide text-white">Andrej Nankov</span>
                </a>

                @if (Route::has('login'))
                    <livewire:welcome.navigation />
                @endif
            </div>
        </header>

        <main id="main-content" class="public-container flex w-full flex-1 items-center py-10 sm:py-14 lg:py-20">
            {{ $slot }}
        </main>

        <footer class="public-footer">
            <div class="public-container py-10 text-center">
                <x-social-icons />

                <div class="mt-6 flex flex-wrap items-center justify-center gap-x-5 gap-y-2 text-sm text-slate-400">
                    <a href="https://github.com/sponsors/nanorocks" target="_blank" rel="noopener noreferrer" class="public-text-link">
                        Support my open-source work
                    </a>
                    <span aria-hidden="true" class="text-slate-700">•</span>
                    <a href="mailto:andrejnankov@gmail.com" class="public-text-link">Get in touch</a>
                </div>

                <p class="mt-6 text-xs text-slate-500">
                    &copy; {{ now()->year }} Andrej Nankov. Built with care in Skopje.
                </p>
            </div>
        </footer>
    </div>

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .catch(error => console.warn('Service worker registration failed:', error));
            });
        }
    </script>
</body>

</html>
