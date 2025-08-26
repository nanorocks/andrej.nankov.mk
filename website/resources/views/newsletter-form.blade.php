<form method="POST" action="{{ route('newsletter.subscribe') }}" class="mt-8 mb-8">
    @csrf
    <input type="email" name="email" required placeholder="Enter your email"
        class="input input-bordered input-dark bg-gray-800 text-white border-gray-700 placeholder-gray-400" />

    <button type="submit"
        class="inline-flex items-center px-6 py-3 bg-red-500 text-white font-semibold rounded-lg shadow hover:bg-red-600 transition-colors duration-200">Subscribe</button>

    <div class="mt-4">
        <x-turnstile data-theme="dark"/>
     </div>
        @if (session('success'))
        <div class="alert alert-success mt-2 w-full">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger mt-2 w-full">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
</form>
