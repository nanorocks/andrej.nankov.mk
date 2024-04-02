<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session()->has('msg'))
                        <div class="bg-gray-800 border-l-4 border-green-500 text-green-200 p-4 mb-4" role="alert">
                            <p class="font-bold">Success!</p>
                            <p>{{ session()->pull('msg') }}</p>
                        </div>
                    @endif
                    {{ __("You're logged in! Nothing here this is only SSO") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
