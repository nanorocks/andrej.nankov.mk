<div class="space-y-5">
    @forelse ($activities as $activity)
        <div style="padding-top: 10px; padding-bottom: 10px;" class="fi-grid-col">
            <section x-data="{
                isCollapsed: false,
            }" class="fi-section fi-section-has-header" data-has-alpine-state="true">
                <header class="fi-section-header"
                    style="display: flex; align-items: center; justify-content: space-between;">
                    <h2 class="fi-section-header-heading" style="display: flex; align-items: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-clock"
                            style="vertical-align: middle; margin-right: 6px;">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span style="vertical-align: middle;">
                            {{ $activity->created_at->format('Y-m-d H:i') }}
                            ({{ ucfirst($activity->description) }})
                        </span>
                    </h2>

                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200"
                        style="margin-left: 1rem;">
                        <span
                            style="text-transform: capitalize; background-color: #e5e7eb; color: #374151; padding: 2px 8px; border-radius: 9999px; font-size: 0.75rem; font-weight: 500;">
                            {{ $activity->log_name }}
                        </span>
                    </span>
                </header>

                <div class="fi-section-content-ctn">
                    <div class="fi-section-content">
                        <div
                            class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg shadow-sm p-6">

                            <div
                                class="flex flex-wrap items-center gap-2 text-sm text-gray-700 dark:text-gray-300 mb-2">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200"
                                    style="text-transform: capitalize;">
                                    (#{{ $activity->id }}) {{ $activity->event }}
                                </span>
                                <span style="text-transform: capitalize;">on</span>
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200"
                                    style="text-transform: capitalize;">
                                    {{ $activity->subject_type }}
                                </span>
                                <span style="text-transform: capitalize;">(ID:
                                    {{ $activity->subject_id }})</span>
                                <span style="text-transform: capitalize;">By</span>
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200"
                                    style="text-transform: capitalize;">
                                    {{ $activity->causer_type }}
                                </span>
                                <span style="text-transform: capitalize;">(ID:
                                    {{ $activity->causer_id }})</span>
                            </div>


                            <div x-data="{ open: false }" class="mt-3" style="margin-top: 1rem;">
                                <button @click="open = !open"
                                    class="cursor-pointer font-semibold text-gray-800 dark:text-gray-200 focus:outline-none"
                                    style="background: none; border: none; padding: 0; font-size: 1rem; text-decoration: underline; cursor: pointer;">
                                    Trace
                                </button>
                                <div x-show="open" x-transition>
                                    <pre
                                        class="mt-2 bg-gray-100 dark:bg-gray-800 p-2 rounded-lg overflow-x-auto text-xs text-gray-900 dark:text-gray-100 w-full"
                                        style="margin-top: 0.5rem; background-color: transparent; padding: 0.5rem; border-radius: 0.5rem; font-size: 0.75rem; width: 100%; resize: vertical; overflow-x: auto; white-space: pre-wrap;">
{{ json_encode($activity->properties->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @empty
        @include('filament.components.no-activities')
    @endforelse

    <div class="mt-8 text-center text-sm">
        {{ $activities->links('filament.components.pagination') }}
    </div>
</div>
