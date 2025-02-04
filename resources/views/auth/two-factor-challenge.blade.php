<x-guest-layout>
    <!-- Logo -->
    <div class="text-center mb-6">
        <img src="{{ asset('logo.jpeg') }}" alt="Your Logo" class="w-45 h-32 mx-auto">
    </div>

    <!-- Session Status (Optional) -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Two-Factor Authentication Form -->
    <form method="POST" action="{{ route('two-factor.login') }}">
        @csrf

        <!-- Authentication Code -->
        <div>
            <x-input-label for="code" :value="__('Authentication code:')" />
            <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" required autocomplete="current-code" />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="mt-4">
            <x-primary-button>
                {{ __('Submit') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Optional: Recovery Code Form (Uncomment if needed) -->
    {{--
    <div class="mt-3">
        <form method="POST" action="{{ route('two-factor.login') }}">
            @csrf

            <div>
                <x-input-label for="recovery_code" :value="__('Recovery Code:')" />
                <x-text-input id="recovery_code" class="block mt-1 w-full" type="text" name="recovery_code" required autocomplete="current-recovery_code" />
                <x-input-error :messages="$errors->get('recovery_code')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-primary-button>
                    {{ __('Submit Recovery Code') }}
                </x-primary-button>
            </div>
        </form>
    </div>
    --}}

    <!-- Logout Form -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <x-primary-button class="mt-4 w-full">
            {{ __('Logout') }}
        </x-primary-button>
    </form>
</x-guest-layout>
