<x-guest-layout>
    <!-- Logo -->
    <div class="text-center mb-6">
        <img src="{{ asset('logo.jpeg') }}" alt="Your Logo" class="w-45 h-32 mx-auto">
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 relative">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full pr-10"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <!-- Eye Toggle Button -->
            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center px-3">
                <img id="eye-icon" src="{{ asset('icons/eye.png') }}" class="h-5 w-5" alt="Show Password">
                <img id="eye-slash-icon" src="{{ asset('icons/eye-slash.png') }}" class="h-5 w-5 hidden" alt="Hide Password">
            </button>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Register Link -->
    <div class="mt-4 text-center">
        <p class="text-sm text-gray-600">
            Don't have an account? <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Register Here') }}</a>
        </p>
    </div>

    <!-- Toggle Password Visibility Script -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeSlashIcon = document.getElementById('eye-slash-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden'); // Hide normal eye icon
                eyeSlashIcon.classList.remove('hidden'); // Show crossed eye icon
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden'); // Show normal eye icon
                eyeSlashIcon.classList.add('hidden'); // Hide crossed eye icon
            }
        }
    </script>
</x-guest-layout>
