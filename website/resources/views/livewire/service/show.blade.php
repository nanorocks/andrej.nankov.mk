<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $service->name ?? __('Show') . ' ' . __('Service') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-base-100 shadow sm:rounded-lg">
            <div class="w-full">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-ba font-semibold leading-6 text-base-900 text-2xl flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-shopping-bag mr-1">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                            {{ __('Show Service') }}
                        </h1>
                        <p class="mt-2 text-sm text-base-700">Details of {{ __('Service') }}.</p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <a type="button" wire:navigate href="{{ route('services.index') }}"
                            class="btn btn-secondary text-base">Back</a>
                    </div>
                </div>

                <div class="flow-root">
                    <div class="mt-8 overflow-x-auto">
                        <div class="inline-block min-w-full py-2 align-middle">
                            <div class="mt-6 border-t border-base-100">
                                <dl class="divide-y divide-base-100">
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Title</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $service->title }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Description</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $service->description }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Price</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $service->price }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Photo Url</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $service->photo_url }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Icon</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $service->icon }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Slug</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $service->slug }}</dd>
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
