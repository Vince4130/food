<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Vos objectifs de perte/prise de poids
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>{{ __("Mesures enregistrées au ") }} {{ date('d/m/Y') }}</p>
                    <div class="card">
                        <div class="card-body bg-light">
                            <table id="mesure__table" class="table table-light authortable table-hover">
                                <thead>
                                    <tr>
                                        <th>Poids (Kg)</th>
                                        <th>Taille (cm)</th>
                                        <th>Age</th>
                                        <th>Genre</th>
                                        <th>Niveau d'activité physique</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $mesures->weight }}</td>
                                        <td>{{ $mesures->height }}</td>
                                        <td>{{ $age }}</td>
                                        <td>{{ ($gender == 'h') ? 'masculin' : 'féminin' }}</td>
                                        <td>{{ $activity }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="card">
                        <div class="card-body bg-light">
