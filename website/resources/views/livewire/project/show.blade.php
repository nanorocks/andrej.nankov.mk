<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $project->name ?? __('Show') . " " . __('Project') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-base-100 shadow sm:rounded-lg">
            <div class="w-full">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-ba font-semibold leading-6 text-base-900 text-2xl flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-layers mr-2">
                                <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                <polyline points="2 17 12 22 22 17"></polyline>
                                <polyline points="2 12 12 17 22 12"></polyline>
                            </svg>
                            {{ __('Show Project') }}
                        </h1>
                        <p class="mt-2 text-sm text-base-700">Details of {{ __('Project') }}.</p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <a type="button" wire:navigate href="{{ route('projects.index') }}" class="btn btn-primary text-base">Back</a>
                    </div>
                </div>

                <div class="flow-root">
                    <div class="mt-8 overflow-x-auto">
                        <div class="inline-block min-w-full py-2 align-middle">
                            <div class="mt-6 border-t border-base-100">
                                <dl class="divide-y divide-base-100">
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Slug</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">{{ $project->slug }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Title</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">{{ $project->title }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Description</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">{{ $project->description }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Start Date</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">{{ $project->start_date }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">End Date</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">{{ $project->end_date }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Project Url</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">{{ $project->project_url }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Image Url</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">{{ $project->image_url }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">Status</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">{{ $project->status }}</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-base-900">User Id</dt>
                                        <dd class="mt-1 text-sm leading-6 text-base-700 sm:col-span-2 sm:mt-0">{{ $project->user_id }}</dd>
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
