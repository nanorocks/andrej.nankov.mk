<form method="POST" action="{{ route('newsletter.subscribe') }}" class="mt-6" novalidate>
    @csrf

    <label for="newsletter-email" class="text-sm font-semibold text-slate-200">Email address</label>
    <input
        id="newsletter-email"
        type="email"
        name="email"
        value="{{ old('email') }}"
        required
        autocomplete="email"
        inputmode="email"
        placeholder="you@example.com"
        class="public-form-input mt-2"
        @error('email') aria-invalid="true" aria-describedby="newsletter-errors" @enderror
    >

    <button type="submit" class="public-button-primary mt-3 w-full">Subscribe</button>

    <div class="mt-5 flex justify-center">
        <x-turnstile data-theme="dark" />
    </div>

    @if (session('success'))
        <div class="public-alert-success" role="status">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div id="newsletter-errors" class="public-alert-error" role="alert">
            <p class="font-semibold">Please check the form:</p>
            <ul class="mt-2 list-disc space-y-1 pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</form>
