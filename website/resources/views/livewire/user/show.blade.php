<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $user->name ?? __('Show') . ' ' . __('User') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-base-100 shadow sm:rounded-lg">
            <div class="w-full">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-base-900">{{ __('Show') }} User</h1>
                        <p class="mt-2 text-sm text-base-700">Details of {{ __('User') }}.</p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <a type="button" wire:navigate href="{{ route('users.index') }}"
                            class="btn btn-primary text base">Back</a>
                    </div>
                </div>

                <div class="flow-root">
                    <div class="mt-8 overflow-x-auto">
                        <div class="inline-block min-w-full py-2 align-middle">
                            <div class="mt-6 border-t border-base-100">
                                <dl class="divide-y divide-base-100">

                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Name</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $user->name ?? 'N/A' }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Avatar</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $user->avatar ?? 'N/A' }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Email</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $user->email ?? 'N/A' }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Phone Number</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $user->phone_number ?? 'N/A' }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Address</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $user->address ?? 'N/A' }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Website Url</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            <a href="{{ $user->website_url ?? 'N/A' }}" target="_blank"
                                                class="link">{{ $user->website_url ?? 'N/A' }}</a>
                                        </dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Medium Url</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            <a href="{{ $user->medium_url ?? 'N/A' }}" target="_blank"
                                                class="link">{{ $user->medium_url ?? 'N/A' }}</a>
                                        </dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Social Media</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $user->social_media ?? 'N/A' }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Role</dt>
                                        <dd
                                            class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0 uppercase">
                                            {{ $user->role ?? 'N/A' }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Bio</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $user->bio ?? 'N/A' }}</dd>
                                    </div>

                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
