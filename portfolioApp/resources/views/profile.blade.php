<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-900 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-base-100 shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="max-w-xl">
                        <livewire:profile.update-profile-information-form />
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-base-100 shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="max-w-xl">
                        <livewire:profile.update-password-form />
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-base-100 shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="max-w-xl">
                        <livewire:profile.delete-user-form />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
