<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __(' Mise à jour de votre objectif') }}
        </h2>

        @if (session('success'))
            <ul class="text-sm text-green-600 space-y-1 mt-2">
                <li>{{ session('success') }}</li>
            </ul>
        @else
            <p class="mt-1 text-sm text-gray-600">{{ __("Modifier les dates et/ou votre poids cible.") }}</p>
        @endif
    </header>

    <form method="post" action="{{ route('targets.update') }}" class="mt-6 space-y-6">
        @csrf

        <input type="hidden" name="target_id" id="target_id" value="{{ $target->id }}">
        <input type="hidden" name="user_id" id="user_id" value="{{ $target->user_id }}">

        <!-- Weight -->
        <x-input-label for="weight" class="form-label" :value="__('Weight')" />
            <x-text-input type="range" class="form-range" min="-50" max="50" id="weight" name="weight" :value="old('weight', $target->weight)" step=".05" />
            <x-input-error :messages="$errors->get('weight')" class="mt-2" />
            <div class="range">
                <div class="range__weight">
                    <div class="range__weight--min">-50 Kg</div>
                    <div class="range__weight--current" id="current_weight"></div>
                    <div class="range__weight--max">+50 Kg</div>
                </div>
            </div>

        <!-- Start Date -->
        <div class="block mt-4">
            <x-input-label for="startDate" :value="__('Date de début')" />
            <x-text-input id="startDate" class="block mt-1 w-full" type="date" name="startDate" :value="old('startDate', $target->startDate)" required autofocus autocomplete="date" />
            <x-input-error :messages="$errors->get('startDate')" class="mt-2" />
            @if (session('failure'))
                <ul class="text-sm text-red-600 space-y-1 mt-2">
                    <li>{{ session('failure') }}</li>
                </ul>
            @endif
        </div>

         <!-- End Date -->
         <div class="block mt-4">
            <x-input-label for="endDate" :value="__('Date de fin')" />
            <x-text-input id="endDate" class="block mt-1 w-full" type="date" name="endDate" :value="old('endDate', $target->endDate)" required autofocus autocomplete="date" />
            <x-input-error :messages="$errors->get('endDate')" class="mt-2" />
            @if (session('failure'))
                <ul class="text-sm text-red-600 space-y-1 mt-2">
                    <li>{{ session('failure') }}</li>
                </ul>
            @endif
        </div>

        <div class="flex items-center gap-4"> <!-- flex items-center justify-end mt-4 -->
            <x-primary-button> <!-- class="ms-3" -->
                {{ __('Submit') }}
            </x-primary-button>
        </div>
    </form>
    <script>
        var current = document.querySelector('#current_weight');
        var weight  = document.querySelector('#weight');
        current.innerText = weight.valueAsNumber + ' Kg';
        weight.addEventListener('change', () => {
            current.innerText = weight.valueAsNumber + ' Kg';
        });
    </script>
</section>
