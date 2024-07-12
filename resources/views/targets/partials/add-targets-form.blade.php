<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Définir votre objectif') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Saisir un poids cible et des dates.") }}
        </p>

        @if (session('success'))
            <ul class="text-sm text-green-600 space-y-1 mt-2">
                <li>{{ session('success') }}</li>
            </ul>
         @endif

        @if (session('failure'))
            <ul class="text-sm text-red-600 space-y-1 mt-2">
                <li>{{ session('failure') }}</li>
            </ul>
         @endif
        <!-- <p class="mt-1 text-sm text-gray-600">
            {{ __("Saisir votre morphologie.") }}
        </p> -->
    </header>

    <form method="POST" action="{{ route('targets.store') }}" class="mt-6 space-y-6">
        @csrf

        <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">

        <!-- Targets -->
        <div class="mt-4">
            <div class="target mt-4">
                
                <x-input-label for="weight" class="form-label" :value="__('Weight')" />
                <x-text-input type="range" class="form-range" min="-50" max="50" id="weight" name="weight" :value="(old('weight')) ? old('weight') : 0" step=".05" />
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
                    <x-text-input id="startDate" class="block mt-1 w-full" type="date" name="startDate" :value="old('startDate')" required autofocus autocomplete="date" />
                    <x-input-error :messages="$errors->get('startDate')" class="mt-2" />
                    @if (session('period'))
                        <ul class="text-sm text-red-600 space-y-1 mt-2">
                            <li>{{ session('period') }}</li>
                        </ul>
                    @endif
                </div>

                <!-- End Date -->
                <div class="block mt-4">
                    <x-input-label for="endDate" :value="__('Date de fin')" />
                    <x-text-input id="endDate" class="block mt-1 w-full" type="date" name="endDate" :value="old('endDate')" required autofocus autocomplete="date" />
                    <x-input-error :messages="$errors->get('endDate')" class="mt-2" />
                    @if (session('period'))
                        <ul class="text-sm text-red-600 space-y-1 mt-2">
                            <li>{{ session('period') }}</li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4"> <!-- flex items-center justify-end mt-4 -->
            <x-primary-button>
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
