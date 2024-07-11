<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __(' Mise à jour de vos mesures') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Modifier votre poids et/ou votre taille.") }}
        </p>
    </header>

    <form method="POST" action="{{ route('measurements.update', $measurement->id) }}" class="mt-6 space-y-6">
        @csrf

        <input type="hidden" name="measurement_id" id="measurement_id" value="{{ $measurement->id }}">
        <!-- Date de la mesure -->
        <div class="block mt-4">
            <x-input-label for="date" :value="__('Date')" />
            <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date', $measurement->date)" required autofocus autocomplete="date" />
            <x-input-error :messages="$errors->get('date')" class="mt-2" />
        </div>

        <!-- Weight -->
        <div class="block mt-4">
            <x-input-label for="weight" :value="__('Poids (Kg)')" />
            <x-text-input id="weight" class="block mt-1 w-full" type="number" name="weight" :value="old('weight', $measurement->weight)" step=".01" required autofocus autocomplete="weight" />
            <x-input-error :messages="$errors->get('weight')" class="mt-2" />
        </div>

        <!-- Height -->
        <div class="block mt-4">
            <div >
                <x-input-label for="height" :value="__('Taille (cm)')" />
                <x-text-input id="height" class="block mt-1 w-full" type="number" name="height" :value="old('height', $measurement->height)" step="1" min="100" required autofocus autocomplete="height" />
                <x-input-error :messages="$errors->get('height')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center gap-4"> <!-- flex items-center justify-end mt-4 -->
            <x-primary-button> <!-- class="ms-3" -->
                {{ __('Submit') }}
            </x-primary-button>
        </div>
    </form>
</section>
