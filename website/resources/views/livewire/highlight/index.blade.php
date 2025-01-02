<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Highlights') }}
    </h2>
</x-slot>

<div class="py-6">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 sm:rounded-lg">
            <div class="w-full">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Highlights') }}</h1>
                        <p class="mt-2 text-sm text-gray-700">A list of all the {{ __('Highlights') }}.</p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <a type="button" wire:navigate href="{{ route('highlights.create') }}" class="block rounded-md bg-primary px-3 py-2 text-center text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2">Add new</a>
                    </div>
                </div>

                <div class="flow-root">
                    <div class="mt-8 overflow-x-auto">
                        <div class="inline-block min-w-full py-2 align-middle">
                            <table class="w-full table table-auto">
                                <thead>
                                <tr>
                                    <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase">
                                        No
                                    </th>
                                    <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase">
                                        Year
                                    </th>
                                    <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase">
                                        Event
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($highlights as $highlight)
                                    <tr wire:key="{{ $highlight->id }}" class="bottom-0">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold">
                                            {{ ++$i }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            {{ $highlight->year }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            {{ $highlight->event }}
                                        </td>
                                        <td class="whitespace-nowrap py-4 px-3 text-sm">
                                            <a
                                                wire:navigate
                                                href="{{ route('highlights.show', $highlight->id) }}"
                                                class="btn btn-sm btn-info mr-2"
                                            >
                                                {{ __('Show') }}
                                            </a>
                                            <a
                                                wire:navigate
                                                href="{{ route('highlights.edit', $highlight->id) }}"
                                                class="btn btn-sm btn-warning mr-2"
                                            >
                                                {{ __('Edit') }}
                                            </a>
                                            <button
                                                class="text-error"
                                                type="button"
                                                wire:click="delete({{ $highlight->id }})"
                                                wire:confirm="Are you sure you want to delete?"
                                            >
                                                {{ __('Delete') }}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>


                            <div class="mt-4 px-4">
                                {!! $highlights->withQueryString()->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
