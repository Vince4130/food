<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
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
                            <table id="mesure__table" class="table table-light authortable table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Poids (Kg)</th>
                                        <th>Taille (cm)</th>
                                        <th>Imc</th>
                
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mesures as $mesure)
                                    <tr>
                                        <td>{{ date('d/m/Y', strtotime($mesure->date)) }}</td>
                                        <td>{{ $mesure->weight }}</td>
                                        <td>{{ $mesure->height }}</td>
                                        <td><?= round($mesure->weight/(($mesure->height)*$mesure->height)*10000, 2) ?></td>
                                    </tr>
                                    @endforeach
                                <tbody>
                            @else
                                <div class="mb-3">
                                    <h4>There are no mesures saved</h4>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
