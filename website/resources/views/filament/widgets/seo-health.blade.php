<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">SEO Health</x-slot>
        <x-slot name="description">Per-page checklist of meta fields used for search & social sharing.</x-slot>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 dark:text-gray-400">
                        <th class="py-2 pr-4">Page</th>
                        <th class="py-2 px-2 text-center">SEO title</th>
                        <th class="py-2 px-2 text-center">SEO description</th>
                        <th class="py-2 px-2 text-center">OG image</th>
                        <th class="py-2 px-2 text-center">Twitter image</th>
                        <th class="py-2 pl-4 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach ($this->getRows() as $row)
                        <tr>
                            <td class="py-2 pr-4 font-medium text-gray-900 dark:text-gray-100">
                                {{ $row['label'] }}
                            </td>
                            @foreach ($row['checks'] as $check)
                                <td class="py-2 px-2 text-center">
                                    @if ($check)
                                        <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-success-100 text-success-700 dark:bg-success-900 dark:text-success-300">
                                            &check;
                                        </span>
                                    @else
                                        <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-danger-100 text-danger-700 dark:bg-danger-900 dark:text-danger-300">
                                            &times;
                                        </span>
                                    @endif
                                </td>
                            @endforeach
                            <td class="py-2 pl-4 text-right">
                                <a href="{{ $row['url'] }}"
                                   class="text-primary-600 hover:text-primary-500 dark:text-primary-400 text-xs font-medium">
                                    Fix &rarr;
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
