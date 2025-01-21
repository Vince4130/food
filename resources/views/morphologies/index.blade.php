<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Historique de vos morphologies au {{ date('d/m/Y') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="card">
                        <div class="card-body bg-light">
                            <!-- <h5 class="container__title">Historique des mesures au {{ date('d/m/Y') }}</h5> -->
                            @if(count($morphologies) > 0)
                            <table id="mesure__table" class="table table-light authortable table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Morphologie</th>
                                        <th>Modifier</th>
                                        <th>Supprimer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($morphologies as $morphology)
                                    <tr>
                                        <td>{{ date('d/m/Y', strtotime($morphology->date)) }}</td>
                                        <td>{{ $morphology->morpho }}</td>
                                        <td> 
                                            <a class="navbar-brand" href="{{ route('morphologies.edit', $morphology->user_id) }}">
                                                <i class="fa-solid fa-pen-to-square fa-lg"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="navbar-brand" href="{{ route('morphologies.destroy', $morphology->id) }}">
                                                <i class="fa-regular fa-trash-can fa-lg"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                <tbody>
                            @else
                                <div class="mb-3">
                                    <h4>Aucune morphologie n'a été enregistrée</h4>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
