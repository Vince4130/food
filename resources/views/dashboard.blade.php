<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Votre dernière mesure d'IMC enregistrée le ") }} {{ date('d/m/Y', strtotime($mesure->date)) }}
                </div>
                <div class="dashboard__data">
                    <div class="imc__donut">
                        <div id="donut"></div>
                    </div>
                    <input type="hidden" name="myImc" id="myImc" value="{{ $imc }}">
                    <div class="imc__donut">
                        <div id="imc" class="imc__donut--justgage">{{ $indicator }}</div>
                    </div>
                   
                    <div>
                        <canvas id="imcChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // var myColors = [
        //     "#a3f5ff",
        //     "#54ce54",
        //     "#ffff00",
        //     "#ffb800",
        //     "#ff6800",
        //     "#f44242"
        // ];

        var myImc = document.querySelector("#myImc").value;

        var g = new JustGage({
            id: "imc",
            value: myImc,
            min: 0,
            max: 60,
            donut: true,
            decimals: 2,
            title: "IMC",
            // levelColors: myColors,
            customSectors: {
                ranges: [{
                    color: "#a3f5ff",
                    lo: 0,
                    hi: 18.5
                }, {
                    color: "#54ce54",
                    lo: 18.6,
                    hi: 24.9
                }, {
                    color: "#ffff00",
                    lo: 25,
                    hi: 29.9
                }, {
                    color: "#ffb800",
                    lo: 30,
                    hi: 34.9
                }, {
                    color: "#ff6800",
                    lo: 35,
                    hi: 39.9
                }, {
                    color: "#f44242",
                    lo: 40,
                    hi: 100
                }]
            },
            pointer: true,
            pointerOptions: {
                toplength: -15,
                bottomlength: 10,
                bottomwidth: 12,
                color: '#8e8e93',
                stroke: '#ffffff',
                stroke_width: 3,
                stroke_linecap: 'round'
            },
            gaugeWidthScale: 0.6,
            counter: true,
            relativeGaugeSize: true            
        });
    </script>
    <script>
        const ctx = document.getElementById('imcChart');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Obésité Modérée', 'Obésité Sévère', 'Obésité Morbide', 'Maigre', 'Normal', 'Surpoids'],
                datasets: [{
                    // label: '# of Votes',
                    data: [35, 40, 41, 18.5, 25, 30],
                    backgroundColor: [
                        '#ffb800',
                        '#ff6800',
                        '#f44242',
                        '#a3f5ff',
                        '#54ce54',
                        '#ffff00',
                    ],
                    borderWidth: 1
                }]
            },
            // options: {
            //     scales: {
            //         y: {
            //             beginAtZero: true
            //         }
            //     }
            // }
        });
    </script>

</x-app-layout>