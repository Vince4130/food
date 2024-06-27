<x-guest-layout>
    <h3 class="title">Bienvenue sur Food</h3>
    <div class="link">
        <a href="{{ route('dashboard') }}">{{ __('Login') }}</a>
        <a href="{{ route('register') }}">{{ __('Register') }}</a>
    </div>
</x-guest-layout>