<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if (session()->has('msg'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert"
                        style="background: #81f8a7ba">
                        <p class="font-bold">Success!</p>
                        <p>{{ session()->pull('msg') }}</p>
                    </div>
                @endif
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in! Nothing here this is only SSO
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
