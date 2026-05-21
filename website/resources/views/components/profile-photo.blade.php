@props([
    'src' => null,
    'alt' => 'Profile Photo',
])

@php
    $path = $src;
    $isExternal = $path && \Illuminate\Support\Str::startsWith($path, ['http://', 'https://']);
    $localExists = $path && ! $isExternal && \Illuminate\Support\Facades\Storage::disk('public')->exists($path);
    $resolved = $localExists
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($path)
        : asset('images/avatar-placeholder.svg');
@endphp

<img src="{{ $resolved }}" alt="{{ $alt }}" {{ $attributes }}>
