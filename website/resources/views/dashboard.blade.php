<x-app-layout>
    <x-slot name="header">
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-red-400">Your account</p>
        <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-white sm:text-3xl">Welcome back, {{ auth()->user()->name }}</h1>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-3">
        <section class="rounded-3xl border border-white/10 bg-[#12151a] p-7 shadow-2xl shadow-black/20 lg:col-span-2" aria-labelledby="dashboard-start-title">
            <p class="public-kicker">Books &amp; games</p>
            <h2 id="dashboard-start-title" class="mt-3 text-2xl font-extrabold text-white sm:text-3xl">Ideas you can put to work</h2>
            <p class="mt-4 max-w-2xl leading-7 text-slate-400">
                Browse practical e-books and original board games about software, startups, and thoughtful decision-making.
            </p>
            <a href="{{ route('shop.index') }}" class="public-button-primary mt-7">Explore the shop</a>
        </section>

        <section class="rounded-3xl border border-white/10 bg-[#12151a] p-7 shadow-2xl shadow-black/20" aria-labelledby="dashboard-downloads-title">
            <p class="public-kicker">Your library</p>
            <h2 id="dashboard-downloads-title" class="mt-3 text-xl font-extrabold text-white">Purchased e-books</h2>
            <p class="mt-4 leading-7 text-slate-400">Download completed e-book purchases at any time from your profile.</p>
            <a href="{{ route('profile') }}" class="public-button-secondary mt-7">View downloads</a>
        </section>
    </div>

    <section class="mt-6 rounded-3xl border border-white/10 bg-white/[0.03] p-7" aria-labelledby="dashboard-account-title">
        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 id="dashboard-account-title" class="text-lg font-bold text-white">Account details</h2>
                <p class="mt-1 text-sm text-slate-400">Update your name, email, password, and download library.</p>
            </div>
            <a href="{{ route('profile') }}" class="public-text-link">Manage profile</a>
        </div>
    </section>
</x-app-layout>
