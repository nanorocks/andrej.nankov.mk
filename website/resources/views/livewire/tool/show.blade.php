<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $tool->name ?? __('Show') . ' ' . __('Tool') }}
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
                                stroke-linejoin="round" class="feather feather-tool mr-2">
                                <path
                                    d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z">
                                </path>
                            </svg>
                            {{ __('Show Tool') }}
                        </h1>
                        <p class="mt-2 text-sm text-base-700">Details of {{ __('Tool') }}.</p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <a type="button" wire:navigate href="{{ route('tools.index') }}"
                            class="btn btn-primary text-base">Back</a>
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
                                            {{ $tool->name }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Slug</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $tool->slug }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Description</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $tool->description }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Photo URL</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            <a href="{{ $tool->photo_url }}"
                                                class="text-blue-500 hover:underline">{{ $tool->photo_url }}</a>
                                        </dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Caption</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            {{ $tool->caption }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Website URL</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">
                                            <a href="{{ $tool->website_url }}"
                                                class="text-blue-500 hover:underline">{{ $tool->website_url }}</a>
                                        </dd>
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
