<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-white">
            {{ __('Information sur vos mesures') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Ajouter votre poids et/ou votre taille.") }}
        </p>
    </header>

    <form method="POST" action="{{ route('measurements.store') }}" class="mt-6 space-y-6">
        @csrf

        <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">

        <!-- Date de la mesure -->
        <div class="block mt-4">
            <x-input-label for="date" :value="__('Date')" />
            <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date')" required autofocus autocomplete="date" />
            <x-input-error :messages="$errors->get('date')" class="mt-2" />
            @if (session('status'))
                <ul class="text-sm text-red-600 space-y-1 mt-2">
                    <li>{{ session('status') }}</li>
                </ul>
            @endif
        </div>

        <!-- Weight -->
        <div class="block mt-4">
            <x-input-label for="weight" :value="__('Poids (Kg)')" />
            <x-text-input id="weight" class="block mt-1 w-full" type="number" name="weight" :value="old('weight')" step=".01" required autofocus autocomplete="weight" />
            <x-input-error :messages="$errors->get('weight')" class="mt-2" />
        </div>

        <!-- Height -->
        <div class="block mt-4">
            <div >
                @php $userHeight = ($height !== null) ? $height->height : ''; @endphp
                <x-input-label for="height" :value="__('Taille (cm)')" />
                <x-text-input id="height" class="block mt-1 w-full" type="number" name="height" :value="old('height', $userHeight)" step="1" min="100" required autofocus autocomplete="height" />
                <x-input-error :messages="$errors->get('height')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center gap-4"> <!-- flex items-center justify-end mt-4 -->
            <x-primary-button> <!--  class="ms-3" -->
                {{ __('Submit') }}
            </x-primary-button>
        </div>
    </form>
</section>
