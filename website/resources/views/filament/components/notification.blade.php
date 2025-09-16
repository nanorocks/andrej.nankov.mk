<div>
    @if ($message)
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, {{ $type === 'success' ? 4000 : 5000 }})"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-2"
            class="fixed top-6 right-6 z-[9999] flex items-center gap-3 px-4 py-3 rounded-lg shadow-lg
                {{ $type === 'success' ? 'bg-green-600 text-white' : 'bg-red-600 text-white' }}"
        >
            @if ($type === 'success')
                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
            @else
                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 9v3.75m0 3.75h.007v.008H12v-.008zM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
            @endif

            <span class="text-sm font-medium">{{ $message }}</span>

            <button @click="show = false" class="ml-2 text-white hover:text-gray-200">
                ✕
            </button>
        </div>
    @endif
</div>
