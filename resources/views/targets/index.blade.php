<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Objectif de perte/prise de poids
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-lg font-medium text-gray-900">
                    {{ __("Résumé de vos mesures enregistrées au ") }} {{ date('d/m/Y') }}
                </div>
                <div class="summary">
                    <div class="mesures">   
                        <x-div-border class="mesures__detail">Poids : {{ $mesures->weight }} Kg</x-div-border>
                        <x-div-border class="mesures__detail">Taille : {{ $mesures->height }} cm</x-div-border>
                        <x-div-border class="mesures__detail">Age : {{ $age }} ans</x-div-border>
                        <x-div-border class="mesures__detail">Genre : {{ ($gender == 'h') ? 'masculin' : 'féminin' }}</x-div-border>
                        <x-div-border class="mesures__detail mesures__detail--activity">Niveau d'activité physique : {{ $activity }}</x-div-border>
                        <x-div-border class="mesures__detail mesures__detail--energy">Dépenses énergétiques journalière : {{ $dailyEnergy }} Kcal/jour</x-div-border>
                        <x-div-border class="mesures__detail mesures__detail--metabolism">
                            Métabolisme de base selon la formule de Mifflin St Jeor : {{ $metabolism }} Kcal/jour
                            <br>                            
                            (10 * Poids) + (6.25 * Taille) - (5 * Âge) + coeff (coeff = -161 pour une femme et +5 pour un homme)
                        </x-div-border>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('targets.partials.add-targets-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

