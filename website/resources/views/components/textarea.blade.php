@props(['disabled' => false])

<textarea @disabled($disabled) rows="8"
    {{ $attributes->merge(['class' => 'textarea textarea-bordered w-full ']) }}></textarea>
