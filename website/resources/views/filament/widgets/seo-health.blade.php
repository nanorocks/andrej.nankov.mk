<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">SEO Health</x-slot>
        <x-slot name="description">Per-page checklist of meta fields used for search & social sharing.</x-slot>

        <style>
            .seo-health-table-wrap {
                margin: 0 -1.5rem -1.5rem;
                overflow-x: auto;
            }

            .seo-health-table {
                width: 100%;
                min-width: 680px;
                border-collapse: collapse;
                table-layout: fixed;
                font-size: .875rem;
            }

            .seo-health-table th {
                padding: .75rem .625rem;
                border-bottom: 1px solid rgb(229 231 235);
                color: rgb(107 114 128);
                font-size: .75rem;
                font-weight: 600;
                letter-spacing: .025em;
                line-height: 1.25rem;
                text-align: center;
                white-space: nowrap;
            }

            .seo-health-table th:first-child,
            .seo-health-table td:first-child {
                width: 24%;
                padding-left: 1.5rem;
                text-align: left;
            }

            .seo-health-table th:last-child,
            .seo-health-table td:last-child {
                width: 5.5rem;
                padding-right: 1.5rem;
                text-align: right;
            }

            .seo-health-table td {
                height: 4rem;
                padding: .75rem .625rem;
                border-bottom: 1px solid rgb(243 244 246);
                text-align: center;
                vertical-align: middle;
            }

            .seo-health-table tbody tr:last-child td {
                border-bottom: 0;
            }

            .seo-health-table tbody tr:hover {
                background: rgb(249 250 251);
            }

            .seo-health-page {
                color: rgb(17 24 39);
                font-weight: 600;
                white-space: nowrap;
            }

            .seo-health-status {
                display: inline-flex;
                width: 1.75rem;
                height: 1.75rem;
                align-items: center;
                justify-content: center;
                border: 1px solid;
                border-radius: 9999px;
            }

            .seo-health-status svg {
                width: 1rem;
                height: 1rem;
                stroke-width: 2.25;
            }

            .seo-health-status--good {
                border-color: rgb(167 243 208);
                background: rgb(236 253 245);
                color: rgb(5 150 105);
            }

            .seo-health-status--missing {
                border-color: rgb(254 202 202);
                background: rgb(254 242 242);
                color: rgb(220 38 38);
            }

            .dark .seo-health-table th {
                border-color: rgb(255 255 255 / 10%);
                color: rgb(156 163 175);
            }

            .dark .seo-health-table td {
                border-color: rgb(255 255 255 / 5%);
            }

            .dark .seo-health-table tbody tr:hover {
                background: rgb(255 255 255 / 5%);
            }

            .dark .seo-health-page {
                color: rgb(243 244 246);
            }

            .dark .seo-health-status--good {
                border-color: rgb(16 185 129 / 30%);
                background: rgb(16 185 129 / 10%);
                color: rgb(52 211 153);
            }

            .dark .seo-health-status--missing {
                border-color: rgb(239 68 68 / 30%);
                background: rgb(239 68 68 / 10%);
                color: rgb(248 113 113);
            }
        </style>

        <div class="seo-health-table-wrap">
            <table class="seo-health-table">
                <thead>
                    <tr>
                        <th>Page</th>
                        <th>SEO title</th>
                        <th>SEO description</th>
                        <th>OG image</th>
                        <th>Twitter image</th>
                        <th><span class="sr-only">Action</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->getRows() as $row)
                        <tr>
                            <td class="seo-health-page">
                                {{ $row['label'] }}
                            </td>
                            @foreach ($row['checks'] as $check)
                                <td>
                                    @if ($check)
                                        <span class="seo-health-status seo-health-status--good" title="Configured">
                                            <x-heroicon-m-check />
                                            <span class="sr-only">Configured</span>
                                        </span>
                                    @else
                                        <span class="seo-health-status seo-health-status--missing" title="Missing">
                                            <x-heroicon-m-x-mark />
                                            <span class="sr-only">Missing</span>
                                        </span>
                                    @endif
                                </td>
                            @endforeach
                            <td>
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
