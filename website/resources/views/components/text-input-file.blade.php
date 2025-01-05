@props(['disabled' => false])

<input type="file" {{ $attributes->merge(['class' => 'file-input file-input-bordered w-full ']) }}>
