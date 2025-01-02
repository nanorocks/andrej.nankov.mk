<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-secondary text-base']) }}>
    {{ $slot }}
</button>
