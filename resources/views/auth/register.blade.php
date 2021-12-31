<x-app-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Display name')" />
                <input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name') }}" required autofocus>
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />
                <input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />
                <input id="password" class="block mt-1 w-full"
                    type="password"
                    name="password"
                    required autocomplete="new-password">
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />
                <input id="password_confirmation" class="block mt-1 w-full"
                    type="password"
                    name="password_confirmation"
                    required autocomplete="new-password">
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <button type="submit" class="btn btn-primary ml-4">{{ __('Register') }}</button>
            </div>
        </form>
    </x-auth-card>
</x-app-layout>
