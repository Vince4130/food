<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            Calcul métabolisme de base (MB) et dépense énergétique journalière (DEJ)
        </h2>
    </x-slot>
    
    @if(count($targets) > 0)
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-lg font-medium text-gray-900">
                    <div class="p-6 px-0 text-lg font-medium text-gray-900">
                        {{ __("Objectif(s) en cours") }}
                    </div>
                    <!-- <div class="card">
                        <div class="card-body bg-light"> -->
                        <table id="mesure__table" class="table table-light authortable table-hover">
                                <thead>
                                    <tr>
                                        <th>Date de début</th>
                                        <th>Date de fin</th>
                                        <th>Poids (Kg)</th>
                                        <th>Modifier</th>
                                        <th>Supprimer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($targets as $target)
                                    <tr>
                                        <td>{{ date('d/m/Y', strtotime($target->startDate)) }}</td>
                                        <td>{{ date('d/m/Y', strtotime($target->endDate)) }}</td>
                                        <td>{{ $target->weight }}</td>
                                        <td> 
                                            <a class="navbar-brand" href="{{ route('targets.edit', $target->id) }}">
                                                <i class="fa-solid fa-pen-to-square fa-lg"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="navbar-brand" href="{{ route('targets.destroy', $target->id) }}">
                                                <i class="fa-regular fa-trash-can fa-lg"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                <tbody>
                            </table>
                        <!-- </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($mesures !== null)
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-lg font-medium text-gray-900">
                    {{ __("Résultats selon vos mesures enregistrées au ") }} {{ date('d/m/Y') }}
                </div>
                <div class="summary">
                    <div class="mesures">   
                        <x-div-border class="mesures__detail"><span class="mesures__detail--legend">Poids :</span> {{ $mesures->weight }} Kg</x-div-border>
                        <x-div-border class="mesures__detail"><span class="mesures__detail--legend">Taille :</span>{{ $mesures->height }} cm</x-div-border>
                        <x-div-border class="mesures__detail"><span class="mesures__detail--legend">Age :</span>{{ $age }} ans</x-div-border>
                        <x-div-border class="mesures__detail"><span class="mesures__detail--legend">Genre :</span> {{ ($gender == 'h') ? 'masculin' : 'féminin' }}</x-div-border>
                        <x-div-border class="mesures__detail mesures__detail--metabolism">
                            <div class="metabolism">
                                <span><span class="mesures__detail--legend">Métabolisme de base selon la formule de Mifflin St Jeor : </span>{{ $metabolism }} Kcal/jour</span>
                                <!-- <br> -->
                                <span>MB = (10 * Poids) + (6.25 * Taille) - (5 * Âge) + coeff (coeff = -161 pour une femme et +5 pour un homme)</span>
                            </div>
                        </x-div-border>
                        <x-div-border class="mesures__detail mesures__detail--activity"><span class="mesures__detail--legend">Niveau d'activité physique (NAP) : </span>{{ $activity }}</x-div-border>
                        <x-div-border class="mesures__detail mesures__detail--energy">
                            <div class="dailynrj">
                                <span><span class="mesures__detail--legend">Dépense énergétique journalière : </span>{{ $dailyEnergy }} Kcal/jour</span>
                                <span>DEJ = MB x NAP</span>
                            </div>
                        </x-div-border>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="card">
                        <div class="card-body bg-light">
                            <div class="mb-3 emptyMesures">
                                <h4>Résumé indisponible, aucune mesure n'a été enregistrée</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg"> <!-- bg-white overflow-hidden shadow-sm sm:rounded-lg -->
                <!-- <div class="max-w-xl"> -->
                    <div class="text-lg font-medium text-gray-900">
                        {{ __("Les calories et le poids") }}
                    </div>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("Les calories dans l'alimentation.") }}
                    </p>
                    <p>
                        La quantité de calories contenue dans les aliments dépend des parts de glucides, protéines et lipides qui les composent : 
                    </p>
                    <ul>
                        <li>1 g de glucides représente 4 Kcal</li>
                        <li>1 g de protéines représente 4 kcal</li>
                        <li>1 g de lipides représente 9Kcal</li>
                    </ul>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("Mécanisme de la perte/prise de poids.") }}
                    </p>
                    <p>
                        Théoriquement pour perdre du poids : les dépenses caloriques doivent être supérieures aux apports caloriques, pour provoquer un déficit calorique.
                    </p>
                    <p>
                        Inversement pour la prise de poids.
                    </p>
                    <p>
                        Pour information 1 Kg équivaut à 7000 kcal.
                    </p>
                <!-- </div> -->
            </div>
        </div>
    </div>
</x-app-layout>

