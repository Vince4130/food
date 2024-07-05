<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Morphologie enregistrée le ') }} {{ date('d/m/Y', strtotime($morphology->date)) }}
        </h2>
        @if (session('status'))
            <ul class="text-sm text-red-600 space-y-1 mt-2">
                <li>{{ session('status') }}</li>
            </ul>
         @endif
         @if (session('statusOk'))
            <ul class="text-sm text-green-600 space-y-1 mt-2">
                <li>{{ session('statusOk') }}</li>
            </ul>
         @endif
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Mettre à jour votre morphologie.") }}
        </p>
    </header>

    <form method="post" action="{{ route('morphologies.update', $morphology->id) }}" class="mt-6 space-y-6">
        @csrf
        
        <input type="hidden" name="date" id="date" value="{{ $morphology->date }}">
        <input type="hidden" name="morphology_id" id="morphology_id" value="{{ $morphology->id }}">

        <div class="mt-4">
            <div class="morpho mt-4">
                <label for="slim">Mince</label>
                <input id="slim" class="block mt-1" type="radio" name="morpho" value="slim" {{ $morphology->morpho == 'slim' ? 'checked' : '' }} required autofocus autocomplete="morpho" />

                <label for="normal">Normale</label>
                <input id="normal" class="block mt-1" type="radio" name="morpho" value="normal" {{ $morphology->morpho == 'normal' ? 'checked' : '' }} required autofocus autocomplete="morpho" />

                <label for="large">Large</label>
                <input id="large" class="block mt-1" type="radio" name="morpho" value="large" {{ $morphology->morpho == 'large' ? 'checked' : '' }} required autofocus autocomplete="morpho" />
            </div>
            <x-input-error :messages="$errors->get('morpho')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Submit') }}
            </x-primary-button>
        </div>
    </form>
</section>
