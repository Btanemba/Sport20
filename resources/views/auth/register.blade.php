<x-guest-layout>

    <!-- Logo -->
    <div class="text-center mb-6">
        <img src="{{ asset('logo.jpeg') }}" alt="Your Logo" class="w-45 h-32 mx-auto">
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 relative">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full pr-10"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <!-- Eye Toggle Button -->
            <button type="button" onclick="togglePassword('password', 'eye-icon', 'eye-slash-icon')" class="absolute inset-y-0 right-0 flex items-center px-3">
                <img id="eye-icon" src="{{ asset('icons/eye.png') }}" class="h-5 w-5" alt="Show Password">
                <img id="eye-slash-icon" src="{{ asset('icons/eye-slash.png') }}" class="h-5 w-5 hidden" alt="Hide Password">
            </button>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4 relative">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full pr-10"
                            type="password"
                            name="password_confirmation"
                            required autocomplete="new-password" />

            <!-- Eye Toggle Button -->
            <button type="button" onclick="togglePassword('password_confirmation', 'eye-icon-confirm', 'eye-slash-icon-confirm')" class="absolute inset-y-0 right-0 flex items-center px-3">
                <img id="eye-icon-confirm" src="{{ asset('icons/eye.png') }}" class="h-5 w-5" alt="Show Password">
                <img id="eye-slash-icon-confirm" src="{{ asset('icons/eye-slash.png') }}" class="h-5 w-5 hidden" alt="Hide Password">
            </button>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Toggle Password Visibility Script -->
    <script>
        function togglePassword(inputId, eyeId, eyeSlashId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(eyeId);
            const eyeSlashIcon = document.getElementById(eyeSlashId);

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
