<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="cupcake">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <div class="drawer">
                <input id="my-drawer-3" type="checkbox" class="drawer-toggle" />
                <div class="drawer-content flex flex-col">
                    <!-- Navbar -->
                    <div class="navbar bg-base-300 w-full">
                        <div class="flex-none lg:hidden">
                            <label for="my-drawer-3" aria-label="open sidebar" class="btn btn-square btn-ghost">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    class="inline-block h-6 w-6 stroke-current">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </label>
                        </div>
                        <div class="mx-2 flex-1 px-2">{{ config('app.name') }}</div>
                        <div class="hidden flex-none lg:block">

                                <div class="dropdown dropdown-end">
                                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                                        <div class="w-10 rounded-full">
                                            <img
                                                alt="Tailwind CSS Navbar component"
                                                src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                                        </div>
                                    </div>

                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('profile')" wire:navigate>
                                            {{ __('Profile') }}
                                        </x-dropdown-link>

                                        <!-- Authentication -->
                                        <button wire:click="logout" class="w-full text-start">
                                            <x-dropdown-link>
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </button>
                                    </x-slot>

                                    <ul
                                        tabindex="0"
                                        class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                                        <li>
                                            <a href="{{ route('profile') }}" class="justify-between">
                                                Profile
                                                <span class="badge">New</span>
                                            </a>
                                        </li>
                                        <li><a>Settings</a></li>
                                        <li><a href="{{ route('logout') }}" >Logout</a></li>
                                    </ul>
                                </div>
                        </div>
                    </div>
                    <!-- Page content here -->
                    <div class="flex flex-row">
                        <div class="drawer lg:drawer-open">
                            <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
                            <div class="drawer-content items-center justify-center">
                                <!-- Page Content -->
                                <main>
                                    {{ $slot }}
                                </main>
                            </div>
                            <div class="drawer-side">
                                <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
                                <ul class="menu bg-base-200 text-base-content min-h-full w-80 p-4">
                                    <!-- Sidebar content here -->
                                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li><a href="{{ route('users.index') }}">Users</a></li>
                                    <li><a href="{{ route('projects.index') }}">Projects</a></li>
                                    <li><a href="{{ route('tools.index') }}">Tools</a></li>
                                    <li><a href="{{ route('categories.index') }}">Categories</a></li>
                                    <li><a href="{{ route('services.index') }}">Services</a></li>
                                    <li><a href="{{ route('menus.index') }}">Menus</a></li>
                                    <li><a href="{{ route('highlights.index') }}">Highlights</a></li>
                                    <li><a href="{{ route('videos.index') }}">Videos</a></li>
                                    <li><a href="{{ route('seo-pages.index') }}">SEO pages</a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="drawer-side">
                    <label for="my-drawer-3" aria-label="close sidebar" class="drawer-overlay"></label>
                    <ul class="menu bg-base-200 min-h-full w-80 p-4">
                        <!-- Sidebar content here -->
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('users.index') }}">Users</a></li>
                        <li><a href="{{ route('projects.index') }}">Projects</a></li>
                        <li><a href="{{ route('tools.index') }}">Tools</a></li>
                        <li><a href="{{ route('categories.index') }}">Categories</a></li>
                        <li><a href="{{ route('services.index') }}">Services</a></li>
                        <li><a href="{{ route('menus.index') }}">Menus</a></li>
                        <li><a href="{{ route('highlights.index') }}">Highlights</a></li>
                        <li><a href="{{ route('videos.index') }}">Videos</a></li>
                        <li><a href="{{ route('seo-pages.index') }}">SEO pages</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>
