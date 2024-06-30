<x-guest-layout>
    <h3 class="title">Bienvenue sur Food</h3>
    <div class="welcome">
        <x-primary-link class="welcome__link" href="{{ route('dashboard') }}">
            {{ __('Login') }}
        </x-primary-link>
        <x-primary-link class="welcome__link" href="{{ route('register') }}">
            {{ __('Register') }}
        </x-primary-link>
    </div>
</x-guest-layout>