<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">SEO Health</x-slot>
        <x-slot name="description">Per-page checklist of meta fields used for search & social sharing.</x-slot>

        <div class="overflow-x-auto -mx-6">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-white/10 text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">
                        <th class="py-3 pl-6 pr-4 text-left">Page</th>
                        <th class="py-3 px-2 text-center">SEO title</th>
                        <th class="py-3 px-2 text-center">SEO description</th>
                        <th class="py-3 px-2 text-center">OG image</th>
                        <th class="py-3 px-2 text-center">Twitter image</th>
                        <th class="py-3 pl-4 pr-6 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @foreach ($this->getRows() as $row)
                        <tr class="transition hover:bg-gray-50 dark:hover:bg-white/5">
                            <td class="py-3 pl-6 pr-4 font-medium text-gray-900 dark:text-gray-100 whitespace-nowrap">
                                {{ $row['label'] }}
                            </td>
                            @foreach ($row['checks'] as $check)
                                <td class="py-3 px-2 text-center">
                                    @if ($check)
                                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 ring-1 ring-inset ring-emerald-600/20 dark:bg-emerald-500/10 dark:text-emerald-400 dark:ring-emerald-500/30">
                                            <x-heroicon-m-check class="h-4 w-4" />
                                        </span>
                                    @else
                                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-red-50 text-red-600 ring-1 ring-inset ring-red-600/20 dark:bg-red-500/10 dark:text-red-400 dark:ring-red-500/30">
                                            <x-heroicon-m-x-mark class="h-4 w-4" />
                                        </span>
                                    @endif
                                </td>
                            @endforeach
                            <td class="py-3 pl-4 pr-6 text-right whitespace-nowrap">
                                <x-filament::link
                                    :href="$row['url']"
                                    icon="heroicon-m-arrow-right"
                                    icon-position="after"
                                    size="xs"
                                >
                                    Fix
                                </x-filament::link>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
