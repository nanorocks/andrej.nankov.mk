{{-- filepath: /home/nanorocks/Documents/andrej.nankov.mk/website/resources/views/livewire/notification-banner.blade.php --}}
<div>
    @if (session('success'))
        <div x-data="notificationComponent({
            notification: {
                id: 'success-{{ \Illuminate\Support\Str::uuid() }}',
                actions: [],
                body: null,
                color: 'success',
                duration: 4000,
                icon: 'heroicon-o-check-circle',
                iconColor: 'success',
                status: 'success',
                title: @js(session('success')),
                view: null,
                viewData: []
            }
        })"
        x-transition:enter-start="fi-transition-enter-start"
        x-transition:leave-end="fi-transition-leave-end"
        class="fi-no-notification fi-status-success"
        wire:key="success-{{ \Illuminate\Support\Str::uuid() }}.notifications"
        x-on:close-notification.window="if ($event.detail.id == 'success-{{ \Illuminate\Support\Str::uuid() }}') close()"
        style="display: flex; visibility: visible; position: fixed; top: 24px; right: 24px; z-index: 9999;">
            <svg class="fi-icon fi-size-md fi-no-notification-icon fi-color fi-color-success"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <div class="fi-no-notification-main">
                <div class="fi-no-notification-text">
                    <h3 class="fi-no-notification-title">
                        {{ session('success') }}
                    </h3>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div x-data="notificationComponent({
            notification: {
                id: 'error-{{ \Illuminate\Support\Str::uuid() }}',
                actions: [],
                body: null,
                color: 'danger',
                duration: 5000,
                icon: 'heroicon-o-x-circle',
                iconColor: 'danger',
                status: 'error',
                title: @js(session('error')),
                view: null,
                viewData: []
            }
        })"
        x-transition:enter-start="fi-transition-enter-start"
        x-transition:leave-end="fi-transition-leave-end"
        class="fi-no-notification fi-status-error"
        wire:key="error-{{ \Illuminate\Support\Str::uuid() }}.notifications"
        x-on:close-notification.window="if ($event.detail.id == 'error-{{ \Illuminate\Support\Str::uuid() }}') close()"
        style="display: flex; visibility: visible; position: fixed; top: 24px; right: 24px; z-index: 9999;">
            <svg class="fi-icon fi-size-md fi-no-notification-icon fi-color fi-color-danger"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v3.75m0 3.75h.007v.008H12v-.008zM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <div class="fi-no-notification-main">
                <div class="fi-no-notification-text">
                    <h3 class="fi-no-notification-title">
                        {{ session('error') }}
                    </h3>
                </div>
            </div>
        </div>
    @endif
</div>
