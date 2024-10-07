<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-white">
            {{ __('Saisir votre niveau d\'activité physique au ') }} {{ date('d/m/Y') }}
        </h2>

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

    </header>

    <form method="POST" action="{{ route('activities.store') }}">
        @csrf

        <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
        @php $today = date('Y-m-d') @endphp
        <input type="hidden" name="date" id="date" value="{{ $today }}">

        <!-- Physical Activity Level -->
        <div class="mt-4 activity">
            <div class="activity__level mt-4">
                <div class="activity__level--name">
                    <p><label for="sedentary">Sédentaire</label></p>
                    <p><input id="sedentary" class="block mt-1" type="radio" name="activity" value="sedentary" {{ old('activity') == 'sedentary' ? 'checked' : '' }} required autofocus autocomplete="activity" /></p>
                </div>
                <div class="activity__level--name">
                    <p><label for="slightly">Légèrement actif</label></p>
                    <p><input id="slightly" class="block mt-1" type="radio" name="activity" value="slightly" {{ old('activity') == 'slightly' ? 'checked' : '' }} required autofocus autocomplete="activity" /></p>
                </div>
                <div class="activity__level--name">
                    <p><label for="moderatly">Modérément actif</label></p>
                    <p><input id="moderatly" class="block mt-1" type="radio" name="activity" value="moderatly" {{ old('activity') == 'moderatly' ? 'checked' : '' }} required autofocus autocomplete="activity" /></p>
                </div>
                <div class="activity__level--name">
                    <p><label for="very">Très actif</label></p>
                    <p><input id="very" class="block mt-1" type="radio" name="activity" value="very" {{ old('activity') == 'very' ? 'checked' : '' }} required autofocus autocomplete="activity" /></p>
                </div>
                <div class="activity__level--name">
                    <p><label for="extremely">Extrêmement actif</label></p>
                    <p><input id="extremely" class="block mt-1" type="radio" name="activity" value="extremely" {{ old('activity') == 'extremely' ? 'checked' : '' }} required autofocus autocomplete="activity" /></p>
                </div>
            </div>

            <x-input-error :messages="$errors->get('date')" class="mt-2" />
            <x-input-error :messages="$errors->get('activity')" class="mt-2" />

            <div class="activity__legend mt-4">
                <div class="activity__legend--cat activity__legend--sed" title="Pas ou peu d'exercice">
                    <div>Sédentaire</div>
                </div>
                <div class="activity__legend--cat activity__legend--sli" title="Exercice 1 à 3 heures par semaine">
                    <div>Légèrement actif.ve</div>
                </div>
                <div class="activity__legend--cat activity__legend--mod" title="Exercice 3 à 5 heures par semaine">
                    <div>Modérément actif.ve</div>
                </div>
                <div class="activity__legend--cat activity__legend--very" title="Exercice 6 à 7 heures par semaine">
                    <div>Très actif.ve</div>
                </div>
                <div class="activity__legend--cat activity__legend--extr" title="Compétition">
                    <div>Extrêmement actif.ve</div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Submit') }}
            </x-primary-button>
        </div>
    </form>
</section>
