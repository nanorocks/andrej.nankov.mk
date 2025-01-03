<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Menus') }}
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
                                stroke-linejoin="round" class="feather feather-menu mr-1">
                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <line x1="3" y1="18" x2="21" y2="18"></line>
                            </svg>
                            {{ __('Menus') }}
                        </h1>
                        <p class="mt-2 text-sm text-base-700">A list of all the {{ __('Menus') }}.</p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <a type="button" wire:navigate href="{{ route('menus.create') }}"
                            class="btn btn-primary text-base">Add new</a>
                    </div>
                </div>

                <div class="flow-root">
                    <div class="mt-8 overflow-x-auto">
                        <div class="inline-block min-w-full py-2 align-middle">
                            <table class="w-full divide-y divide-base-300">
                                <thead>
                                    <tr>
                                        <th scope="col"
                                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-base-500">
                                            No</th>
                                        <th scope="col"
                                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-base-500">
                                            Title</th>
                                        <th scope="col"
                                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-base-500">
                                            Slug</th>
                                        <th scope="col"
                                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-base-500">
                                            Url</th>
                                        <th scope="col"
                                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-base-500">
                                            Parent Id</th>
                                        <th scope="col"
                                            class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-base-500">
                                            Order</th>
                                        <th scope="col"
                                            class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-base-500">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-base-200 bg-base-100">
                                    @foreach ($menus as $menu)
                                        <tr class="even:bg-base-50" wire:key="{{ $menu->id }}">
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-base-900">
                                                {{ ++$i }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-base-500">
                                                {{ $menu->title }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-base-500">
                                                {{ $menu->slug }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-base-500">
                                                {{ $menu->url }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-base-500">
                                                {{ $menu->parent_id }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-base-500">
                                                {{ $menu->order }}</td>
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-base-900 flex mt-3">
                                                <a wire:navigate href="{{ route('menus.show', $menu->id) }}"
                                                    class="text-secondary mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                        height="20" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-eye">
                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                    </svg>
                                                </a>
                                                <a wire:navigate href="{{ route('menus.edit', $menu->id) }}"
                                                    class="text-success font-bold mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                        height="20" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-edit">
                                                        <path
                                                            d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                        </path>
                                                        <path
                                                            d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                        </path>
                                                    </svg>
                                                </a>
                                                <button class="text-error font-bold" type="button"
                                                    wire:click="delete({{ $menu->id }})"
                                                    wire:confirm="Are you sure you want to delete?">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                        height="20" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-trash-2">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path
                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                        </path>
                                                        <line x1="10" y1="11" x2="10"
                                                            y2="17"></line>
                                                        <line x1="14" y1="11" x2="14"
                                                            y2="17"></line>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-4 px-4">
                                {!! $menus->withQueryString()->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
