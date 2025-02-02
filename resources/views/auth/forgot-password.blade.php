<x-guest-layout>
    <x-auth.card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 text-gray-500 fill-current" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600 dark:text-gray-200">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        <x-auth.session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth.validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <x-bit.input.group for="email" :value="__('Email')">
                <x-bit.input.text id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required autofocus />
            </x-bit.input.group>

            <div class="flex items-center justify-end mt-4">
                <x-bit.button.flat.primary type="submit">
                    {{ __('Email Password Reset Link') }}
                </x-bit.button.flat.primary>
            </div>
        </form>
    </x-auth.card>
</x-guest-layout>
