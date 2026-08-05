@props([
    'size' => 'large',
    'priority' => false,
])

@php
    $sizeClass = match ($size) {
        'small' => 'h-20 w-20',
        'medium' => 'h-28 w-28',
        default => 'h-36 w-36 sm:h-44 sm:w-44',
    };
@endphp

<div {{ $attributes->class(['public-profile-photo', $sizeClass]) }}>
    <img
        src="{{ asset('assets/avatars/andrej-nankov-profile.png') }}"
        alt="Andrej Nankov"
        width="460"
        height="460"
        class="h-full w-full object-cover"
        loading="{{ $priority ? 'eager' : 'lazy' }}"
        decoding="async"
        @if ($priority) fetchpriority="high" @endif
    >
</div>
