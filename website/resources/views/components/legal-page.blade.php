@props(['title', 'description', 'updated' => 'August 6, 2026'])

<x-guest-layout>
    @push('meta')
        <meta name="description" content="{{ $description }}">
    @endpush

    <article class="mx-auto w-full max-w-4xl">
        <header class="border-b border-white/10 pb-8">
            <p class="public-kicker">Legal information</p>
            <h1 class="mt-3 text-4xl font-extrabold tracking-tight text-white sm:text-5xl">{{ $title }}</h1>
            <p class="mt-4 text-sm text-slate-400">Last updated: {{ $updated }}</p>
        </header>

        <div class="public-prose mt-8">
            {{ $slot }}
        </div>

        <aside class="mt-10 rounded-2xl border border-white/10 bg-white/[0.04] p-6 text-sm leading-7 text-slate-300">
            Questions about this policy? Email
            <a href="mailto:andrejnankov@gmail.com" class="font-semibold text-red-400 hover:text-red-300">andrejnankov@gmail.com</a>.
        </aside>
    </article>
</x-guest-layout>
