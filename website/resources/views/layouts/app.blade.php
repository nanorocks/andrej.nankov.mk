<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-[#090b0e]" data-theme="night">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Andrej Nankov') }}</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>

<body class="app-site min-h-screen bg-[#090b0e] font-sans text-slate-100 antialiased">
    <a href="#main-content" class="public-skip-link">Skip to content</a>
    <div class="public-background" aria-hidden="true"></div>

    <div class="relative flex flex-col min-h-screen isolate">
        <header class="public-header">
            <div class="flex items-center justify-between gap-5 py-4 public-container min-h-20">
                <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-lg focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-red-500" aria-label="Andrej Nankov — Home">
                    <span class="public-brand-mark" aria-hidden="true">
                        <img src="{{ asset('assets/avatars/personal_logo_notes_nankov.png') }}" alt="" width="48" height="48">
                    </span>
                    <span class="hidden leading-tight sm:block">
                        <span class="block text-sm font-bold tracking-wide text-white">MSc. Andrej Nankov</span>
                        <span class="block text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Customer account</span>
                    </span>
                </a>

                <livewire:layout.navigation />
            </div>
        </header>

        @isset($header)
            <section class="border-b border-white/10 bg-white/[0.02]">
                <div class="py-6 public-container">{{ $header }}</div>
            </section>
        @endisset

        <main id="main-content" class="flex-1 w-full py-8 public-container sm:py-12">
            {{ $slot }}
        </main>

        <footer class="public-footer">
            <div class="flex flex-col gap-4 text-sm public-container py-7 text-slate-500 sm:flex-row sm:items-center sm:justify-between">
                <p>&copy; {{ now()->year }} Andrej Nankov.</p>
                <nav class="flex flex-wrap gap-x-5 gap-y-2" aria-label="Footer navigation">
                    <a href="{{ route('shop.index') }}" class="public-text-link">Shop</a>
                    <a href="{{ route('orders.index') }}" class="public-text-link">Orders</a>
                    <a href="{{ route('legal.privacy') }}" class="public-text-link">Privacy</a>
                    <a href="{{ route('legal.terms') }}" class="public-text-link">Terms</a>
                    <button type="button" data-cookie-settings class="public-text-link">Cookie choices</button>
                </nav>
            </div>
        </footer>
    </div>

    @include('partials.cookie-consent')
</body>

</html>
