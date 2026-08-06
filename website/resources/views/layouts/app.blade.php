<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-[#090b0e]" data-theme="night">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Andrej Nankov') }}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>

<body class="app-site min-h-screen bg-[#090b0e] font-sans text-slate-100 antialiased">
    <a href="#main-content" class="public-skip-link">Skip to content</a>
    <div class="public-background" aria-hidden="true"></div>

    <div class="relative isolate flex min-h-screen flex-col">
        <header class="public-header">
            <div class="public-container flex min-h-20 items-center justify-between gap-5 py-4">
                <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-lg focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-red-500" aria-label="Andrej Nankov — Home">
                    <span class="public-brand-mark" aria-hidden="true">
                        <img src="{{ asset('assets/avatars/personal_logo_notes_nankov.png') }}" alt="" width="48" height="48">
                    </span>
                    <span class="hidden text-sm font-bold tracking-wide text-white sm:inline">Andrej Nankov</span>
                </a>

                <livewire:layout.navigation />
            </div>
        </header>

        @isset($header)
            <section class="border-b border-white/10 bg-white/[0.02]">
                <div class="public-container py-6">{{ $header }}</div>
            </section>
        @endisset

        <main id="main-content" class="public-container w-full flex-1 py-8 sm:py-12">
            {{ $slot }}
        </main>

        <footer class="public-footer">
            <div class="public-container flex flex-col gap-2 py-7 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between">
                <p>&copy; {{ now()->year }} Andrej Nankov.</p>
                <a href="{{ route('shop.index') }}" class="public-text-link">Board games &amp; e-books</a>
            </div>
        </footer>
    </div>
</body>

</html>
