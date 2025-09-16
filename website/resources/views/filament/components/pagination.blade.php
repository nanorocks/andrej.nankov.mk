@if ($paginator->hasPages())
    <div class="shadow rounded-lg p-4">
        <nav aria-label="Pagination navigation" role="navigation" class="fi-pagination my-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                <!-- Overview -->
                <span class="fi-pagination-overview text-sm text-gray-500">
                    Showing {{ ($paginator->currentPage() - 1) * $paginator->perPage() + 1 }}
                    to {{ min($paginator->currentPage() * $paginator->perPage(), $paginator->total()) }}
                    of {{ $paginator->total() }} results
                </span>

                <!-- Records Per Page Select -->
                <div class="fi-pagination-records-per-page-select-ctn flex items-center gap-2">
                    <label class="fi-pagination-records-per-page-select fi-compact text-sm text-gray-500">
                        <span class="fi-input-wrp-label mr-2">Per page</span>
                        <select class="fi-select-input border-gray-300 rounded"
                            onchange="window.location.href=this.value">
                            @foreach ([5, 10, 25, 50] as $size)
                                <option value="{{ request()->fullUrlWithQuery(['perPage' => $size]) }}"
                                    @if ($paginator->perPage() == $size) selected @endif>
                                    {{ $size }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                </div>
            </div>

            <!-- Pagination Links -->
            <ol class="fi-pagination-items flex justify-center gap-1 mt-3">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li>
                        <span class="fi-pagination-item-btn px-3 py-2 rounded  text-gray-400 cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevrons-left">
                                <polyline points="11 17 6 12 11 7"></polyline>
                                <polyline points="18 17 13 12 18 7"></polyline>
                            </svg></span>
                    </li>
                @else
                    <li>
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                            class="fi-pagination-item-btn px-3 py-2 rounded hover:bg-gray-50 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevrons-left">
                                <polyline points="11 17 6 12 11 7"></polyline>
                                <polyline points="18 17 13 12 18 7"></polyline>
                            </svg></a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li>
                            <span class="fi-pagination-item-btn px-3 py-2  text-gray-400">{{ $element }}</span>
                        </li>
                    @endif
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li>
                                    <span
                                        class="fi-pagination-item-btn px-3 py-2 bg-blue-600 text-white rounded font-bold shadow"
                                        style="opacity: 0.6;"
                                    >{{ $page }}</span>
                                </li>
                            @else
                                <li>
                                    <a href="{{ $url }}"
                                        class="fi-pagination-item-btn px-3 py-2 text-blue-700 rounded hover:bg-blue-50 transition">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li>
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                            class="fi-pagination-item-btn transition">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevrons-right">
                                <polyline points="13 17 18 12 13 7"></polyline>
                                <polyline points="6 17 11 12 6 7"></polyline>
                            </svg>
                        </a>
                    </li>
                @else
                    <li>
                        <span class="fi-pagination-item-btn cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevrons-right">
                                <polyline points="13 17 18 12 13 7"></polyline>
                                <polyline points="6 17 11 12 6 7"></polyline>
                            </svg>
                        </span>
                    </li>
                @endif
            </ol>
        </nav>
    </div>
@endif
