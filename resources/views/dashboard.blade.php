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
                    {{ __("Vos dernières mesure d'IMC et poids enregistrés le ") }} {{ date('d/m/Y', strtotime($mesure->date)) }}
                </div>
                <div class="dashboard__data">
                    <!-- <div class="imc__donut">
                        <div id="donut"></div>
                    </div> -->
                    <input type="hidden" name="myImc" id="myImc" value="{{ $imc }}">
                    <input type="hidden" name="myWeight" id="myWeight" value="{{ $mesure->weight }}">
                    <input type="hidden" name="range" id="range" value="{{ json_encode($weightsRange) }}">

                    <div class="imc__donut">
                        <div id="imc" class="imc__donut--justgage">{{ $indicator }}</div>
                        <div id="weight" class="imc__donut--justgage">Poids actuel</div>
                    </div>

                    <div class="imc__legend">
                            <div class="imc__legend--cat imc__legend--maigre">
                                <div title="[imc<18.5]">Maigreur</div>
                            </div>
                            <div class="imc__legend--cat imc__legend--normale">
                                <div title="[18.5<imc<25]">Corpulence normale</div>
                            </div>
                            <div class="imc__legend--cat imc__legend--surpoids">
                                <div title="[25<imc<30]">Surpoids</div>
                            </div>
                            <div class="imc__legend--cat imc__legend--obesitemod">
                                <div title="[30<imc<35]">Obésité modérée</div>
                            </div>
                            <div class="imc__legend--cat imc__legend--obesitesev">
                                <div title="[35<imc<40]">Obésisté sévère</div>
                            </div>
                            <div class="imc__legend--cat imc__legend--obesitemor">
                                <div title="[imc>40]">Obésité morbide</div>
                            </div>
                    </div>
                    <!-- <div>
                        <canvas id="imcChart"></canvas>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Courbe de poids du mois de ") }} {{ $currentMonth }}
                </div>
                <div class="dashboard__data data__weight">
                    <input type="hidden" name="weights" id="weights" value="{{ json_encode($weightsCurrentMonth) }}">   
                    <div class="dashboard__data--weightsChart">
                        <canvas id="weightsChart"></canvas>
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

        var myImc    = document.querySelector("#myImc").value;
        var myWeight = document.querySelector("#myWeight").value;
        var range =  document.querySelector("#range").value;
        range = JSON.parse(range);

        for(i=0; i < range.length; i++) {
            range[i] = Math.floor(range[i]*100)/100;
        }

        var g1 = new JustGage({
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

        var g2 = new JustGage({
            id: "weight",
            value: myWeight,
            min: 0,
            max: 300,
            donut: true,
            decimals: 2,
            title: "Poids",
            // levelColors: myColors,
            customSectors: {
                ranges: [{
                    color: "#a3f5ff",
                    lo: 0,
                    hi: range[0] - 0.01
                }, {
                    color: "#54ce54",
                    lo: range[0],
                    hi: range[1] - 0.01
                }, {
                    color: "#ffff00",
                    lo: range[1],
                    hi: range[2] - 0.01
                }, {
                    color: "#ffb800",
                    lo: range[2],
                    hi: range[3] - 0.01
                }, {
                    color: "#ff6800",
                    lo: range[3],
                    hi: range[4] - 0.01
                }
                , {
                    color: "#f44242",
                    lo: range[4],
                    hi: 300
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
        const ctx   = document.getElementById('weightsChart');
        var weights = document.querySelector("#weights").value;
        weights = JSON.parse(weights);
        
        const labels = Object.keys(weights);
        const data   = Object.values(weights);

        const formatData = data.map(value => value !== null ? value : NaN);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Poids en Kg',
                    data: weights,
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                locale: "fr-FR",
                responsive: true,
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day',
                            tooltypeFormat: 'DD/MM/YYYY',
                            displayFormats: {
                                day: 'dd MM'
                            }
                        }
                    },
                    y: {
                        label: 'Poids',
                        beginAtZero: true,
                        max: 200
                    }
                },
            }
        });
    </script>

</x-app-layout>
