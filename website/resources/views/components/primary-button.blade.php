<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary text-base']) }}>
    {{ $slot }}
</button>
