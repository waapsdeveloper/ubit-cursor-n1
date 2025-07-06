<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Join Sahil e Firdaus Auctions</h2>
        <p class="text-gray-600">Create your account to start bidding on exclusive properties</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms and Conditions -->
        <div class="mt-4">
            <label class="flex items-center">
                <input type="checkbox" name="agree_terms" required class="rounded border-gray-300 text-ubit-purple-600 shadow-sm focus:border-ubit-purple-300 focus:ring focus:ring-ubit-purple-200 focus:ring-opacity-50">
                <span class="ml-2 text-sm text-gray-600">
                    I agree to the <a href="#" class="text-ubit-purple-600 hover:text-ubit-purple-500">Terms and Conditions</a>
                </span>
            </label>
            <x-input-error :messages="$errors->get('agree_terms')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="bg-ubit-purple-500 hover:bg-ubit-purple-600">
                {{ __('Create Account') }}
            </x-primary-button>
        </div>

        <!-- Help Text -->
        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <p class="text-sm text-gray-600">
                <strong>Need help?</strong> Contact us at 
                <a href="mailto:admin@sahilefirdaus.com" class="text-ubit-purple-600 hover:text-ubit-purple-500">admin@sahilefirdaus.com</a> 
                for any questions about our auction platform.
            </p>
        </div>
    </form>
</x-guest-layout>

