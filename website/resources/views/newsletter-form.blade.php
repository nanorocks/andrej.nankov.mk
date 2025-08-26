<form method="POST" action="{{ route('newsletter.subscribe') }}"
      class="mt-8 mb-8 w-full max-w-xl mx-auto">
    @csrf

    <!-- Wrapper for input + button -->
    <div class="flex flex-col sm:flex-row gap-4 w-80 mx-auto">
        <!-- Email Input -->
        <input type="email" name="email" required placeholder="Enter your email"
            class="flex-1 input input-bordered bg-gray-800 text-white border-gray-700 placeholder-gray-400 w-full" />

        <!-- Subscribe Button -->
        <button type="submit"
            class="btn bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg shadow w-full sm:w-auto border-0">
            Subscribe
        </button>
    </div>

    <!-- Captcha -->
    <div class="mt-4">
        <x-turnstile data-theme="dark"/>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success mt-2 w-full">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-error mt-2 w-full">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
</form>
