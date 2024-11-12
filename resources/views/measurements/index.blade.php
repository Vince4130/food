<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            Historique des mesures au {{ date('d/m/Y') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="card">
                        <div class="card-body bg-light">
                            <!-- <h5 class="container__title">Historique des mesures au {{ date('d/m/Y') }}</h5> -->
                            @if(count($mesures) > 0)
                            <table id="mesure__table" class="table table-light table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Poids (Kg)</th>
                                        <th>Taille (cm)</th>
                                        <th>Imc</th>
                                        <th>Tendance</th>
                                        <th>Modifier</th>
                                        <th>Supprimer</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    @php $count = 0 @endphp
                                    @foreach($mesures as $mesure)
                                    <tr>
                                        <td>{{ date('d/m/Y', strtotime($mesure->date)) }}</td>
                                        <td>{{ $mesure->weight }}</td>
                                        <td>{{ $mesure->height }}</td>
                                        <td>{{ round($mesure->weight/($mesure->height*$mesure->height)*10000, 2) }}</td>
                                        <td>
                                            <div class="tendencies">
                                                @if($tendances[$count] == '+')
                                                    <img src="{{ asset('img/prise.png') }}" alt="prise" width="30" />
                                                @elseif($tendances[$count] == '-')
                                                    <img src="{{ asset('img/perte.png') }}" alt="perte" width="30" />
                                                @elseif($tendances[$count] == "=") 
                                                    <img src="{{ asset('img/stable.png') }}" alt="stable" width="25" />
                                                @elseif($tendances[0])
                                                    -
                                                @endif 
                                            </div>
                                        </td>
                                        <td> 
                                            <a class="navbar-brand" href="{{ route('measurements.edit', $mesure->id) }}">
                                                <i class="fa-solid fa-pen-to-square fa-lg"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="navbar-brand" data-bs-toggle="modal" data-bs-target="#delMesure{{ $mesure->id }}">
                                                <i class="fa-regular fa-trash-can fa-lg"></i>
                                            </a>
                                        </td>
                                        <div class="modal fade" id="delMesure{{ $mesure->id }}" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Supprimez une mesure</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Voulez-vous supprimer la mesure du  {{ date('d/m/Y', strtotime($mesure->date)) }} ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a class="btn btn-dark" href="{{ route('measurements.destroy', $mesure->id) }}">Yes</a>
                                                        <a class="btn btn-dark" data-bs-dismiss="modal" aria-label="close">No</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                    @php $count++ @endphp
                                    @endforeach
                                <tbody>
                            </table>
                            
                            <!-- Pagination Links -->
                            <div>
                                {{ $mesures->links() }}
                            </div>

                            @else
                                <div class="mb-3">
                                    <h4>Aucune mesure n'a été enregistrée</h4>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
