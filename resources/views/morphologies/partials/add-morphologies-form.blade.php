<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Saisir votre morphologie au ') }} {{ date('d/m/Y') }}
        </h2>

        <!-- <p class="mt-1 text-sm text-gray-600">
            {{ __("Saisir votre morphologie.") }}
        </p> -->
    </header>

    <form method="POST" action="{{ route('morphologies.store') }}">
        @csrf

        <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
        @php $today = date('Y-m-d') @endphp
        <input type="hidden" name="date" id="date" value="{{ $today }}">

        <!-- Morphology -->
        <div class="mt-4">
            <div class="morpho mt-4">
                <label for="slim">Mince</label>
                <input id="slim" class="block mt-1" type="radio" name="morpho" value="slim" {{ old('morpho') == 'slim' ? 'checked' : '' }} required autofocus autocomplete="morpho" />

                <label for="normal">Normale</label>
                <input id="normal" class="block mt-1" type="radio" name="morpho" value="normal" {{ old('morpho') == 'large' ? 'checked' : '' }} required autofocus autocomplete="morpho" />

                <label for="large">Large</label>
                <input id="large" class="block mt-1" type="radio" name="morpho" value="large" {{ old('morpho') == 'large' ? 'checked' : '' }} required autofocus autocomplete="morpho" />
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
