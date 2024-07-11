<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Définir votre objectif') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Saisir un poids et une date cibles.") }}
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

    <form method="POST" action="{{ route('morphologies.store') }}" class="mt-6 space-y-6">
        @csrf

        <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
        @php $today = date('Y-m-d') @endphp
        <input type="hidden" name="date" id="date" value="{{ $today }}">

        <!-- Targets -->
        <div class="mt-4">
            <div class="target mt-4">
                <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">

                <x-input-label for="weight" class="form-label" :value="__('Weight')" />
                <input type="range" class="form-range" min="-50" max="50" id="weight" name="weight" value="0" step=".05">
                <div class="range">
                    <div class="range__weight">
                        <div class="range__weight--min">-50 Kg</div>
                        <div class="range__weight--current" id="current_weight"></div>
                        <div class="range__weight--max">+50 Kg</div>
                    </div>
                </div>
                
                <!-- Date début -->
                <div class="block mt-4">
                    <x-input-label for="startDate" :value="__('Date de début')" />
                    <x-text-input id="startDate" class="block mt-1 w-full" type="date" name="startDate" :value="old('startDate')" min="{{ date('Y-m-d') }}" required autofocus autocomplete="date" />
                    <x-input-error :messages="$errors->get('startDate')" class="mt-2" />
                    @if (session('status'))
                        <ul class="text-sm text-red-600 space-y-1 mt-2">
                            <li>{{ session('status') }}</li>
                        </ul>
                    @endif
                </div>

                <!-- Date fin -->
                <div class="block mt-4">
                    <x-input-label for="endDate" :value="__('Date de fin')" />
                    <x-text-input id="endDate" class="block mt-1 w-full" type="date" name="endDate" :value="old('endDate')" min="{{ date('Y-m-d', strtotime('+1 week')) }}" required autofocus autocomplete="date" />
                    <x-input-error :messages="$errors->get('endDate')" class="mt-2" />
                    @if (session('status'))
                        <ul class="text-sm text-red-600 space-y-1 mt-2">
                            <li>{{ session('status') }}</li>
                        </ul>
                    @endif
                </div>
            </div>
            <x-input-error :messages="$errors->get('date')" class="mt-2" />
            <x-input-error :messages="$errors->get('weight')" class="mt-2" />
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
