<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Update') }} Service
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
                                stroke-linejoin="round" class="feather feather-edit mr-2">
                                <path
                                    d="M11 4h2v2h-2zM4 11h2v2H4zM11 11h2v2h-2zM18 11h2v2h-2zM4 18h2v2H4zM11 18h2v2H11zM18 18h2v2h-2z">
                                </path>
                                <path d="M4 4h2v2H4zM18 4h2v2h-2z"></path>
                            </svg>
                            {{ __('Update Service') }}
                        </h1>
                        <p class="mt-2 text-sm text-base-700">Update existing {{ __('Service') }}.</p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <a type="button" wire:navigate href="{{ route('services.index') }}"
                            class="btn btn-primary text-base">Back</a>
                    </div>
                </div>

                <div class="flow-root">
                    <div class="mt-8 overflow-x-auto">
                        <div class="max-w-xl py-2 align-middle">
                            <form method="POST" wire:submit="save" role="form" enctype="multipart/form-data">
                                {{ method_field('PATCH') }}
                                @csrf
                                @include('livewire.service.form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
