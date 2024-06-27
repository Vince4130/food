<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

         <!-- Firstname -->
         <div class="mt-4">
            <x-input-label for="firstname" :value="__('Firstname')" />
            <x-text-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
            <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
        </div>

        <!-- Birthdate -->
        <div class="mt-4">
            <x-input-label for="birth" :value="__('Birthdate')" />
            <x-text-input id="birth" class="block mt-1 w-full" type="date" name="birth" :value="old('birth')" required autofocus autocomplete="birth" />
            <x-input-error :messages="$errors->get('birth')" class="mt-2" />
        </div>

         <!-- Sexe -->
         <div class="mt-4">
            <x-input-label  for="sexe" :value="__('Sexe')" />
            <div class="sexe mt-4">
                <label for="homme">Homme</label>
                <input id="homme" class="block mt-1" type="radio" name="sexe" value="h" {{ old('sexe') == 'h' ? 'checked' : '' }} required autofocus autocomplete="sexe" />
                <label for="femme">Femme</label>
                <input id="femme" class="block mt-1" type="radio" name="sexe" value="f" {{ old('sexe') == 'f' ? 'checked' : '' }} required autofocus autocomplete="sexe" />
            </div>
            <x-input-error :messages="$errors->get('sexe')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
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

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
