<x-guest-layout>
    <div class="mb-6">
        <p class="serif italic text-sm text-[#B8860B] mb-2">{{ __('Confirmacion requerida') }}</p>
        <h1 class="serif text-3xl font-bold text-gray-900 mb-4">{{ __('Confirma tu contrasena') }}</h1>
    </div>

    <div class="mb-4 text-sm text-gray-600 leading-relaxed">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
