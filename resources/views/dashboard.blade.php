<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }} : {{ ($user->pseudo != null) ? $user->pseudo : $user->firstname }} {{ ($mesure !== null) ? $mesure->height/100 : '' }}  {{ ($mesure !== null) ? ' m,' : '' }} {{ $age }} ans, de sexe {{ ($user->sexe == 'h') ? 'masculin' : 'féminin' }}   
        </h2>
    </x-slot>

    @if($mesure !== null)
    <div class="py-12">
        
        <div class="anchor pagination">
            <p class="page-item">
                <a class="page-link anchor__link" href="#bottom"><i class="fa-regular fa-square-caret-down fa-2xl"></i></a>
            </p>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Vos dernières mesure d'IMC et poids enregistrés : ") }} {{ ($mesure !== null) ? date('d/m/Y', strtotime($mesure->date)) : 'aucune données à ce jour' }}
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
                            <div class="imc__legend--cat imc__legend--maigre"  title="[imc<18.5]">
                                <div>Maigreur</div>
                            </div>
                            <div class="imc__legend--cat imc__legend--normale" title="[18.5<imc<25]">
                                <div>Corpulence normale</div>
                            </div>
                            <div class="imc__legend--cat imc__legend--surpoids" title="[25<imc<30]">
                                <div>Surpoids</div>
                            </div>
                            <div class="imc__legend--cat imc__legend--obesitemod" title="[30<imc<35]">
                                <div>Obésité modérée</div>
                            </div>
                            <div class="imc__legend--cat imc__legend--obesitesev">
                                <div title="[35<imc<40]">Obésisté sévère</div>
                            </div>
                            <div class="imc__legend--cat imc__legend--obesitemor"  title="[imc>40]">
                                <div>Obésité morbide</div>
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
                    <div class="months">
                        <a class="months__links" href=""><i class="fa-regular fa-square-caret-left fa-xl"></i></a>
                        <a class="months__links" href=""><i class="fa-regular fa-square-caret-right fa-xl"></i></a>
                    </div>
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Courbe imc du mois de ") }} {{ $currentMonth }}
                </div>
                <div class="dashboard__data data__imc">
                    <input type="hidden" name="imcs" id="imcs" value="{{ json_encode($imcsCurrentMonth) }}">   
                    <div class="dashboard__data--imcsChart">
                        <canvas id="imcsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Calcul poids idéal") }}
                </div>
                <div class="dashboard__idealweight">
                    
                    <input type="hidden" name="idealWeight" id="idealWeight" value="{{ json_encode($mesure) }}">   
                    <div class="dashboard__idealweight--lorentz" id="lorentz">
                        <p>
                            {{ __("Selon la formule de Lorentz")}}  
                        </p>
                    </div>

                    <input type="hidden" name="age" id="age" value="{{ $age }}">
                    <input type="hidden" name="morphoCoefficient" id="morphoCoefficient" value="{{ $morphoCoefficient }}">
                    <div class="dashboard__idealweight--creff" id="creff">
                        <p>
                            {{ __("Selon la formule de Creff ")}} (morphologie : @if($morpho !== null) {{ ($morpho->morpho == 'normal') ? 'normale)' : (($morpho->morpho == 'slim') ? 'mince)' : 'large)') }} @else non renseignée) @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="anchor pagination" id="bottom">
            <p class="page-item">
                <a class="page-link anchor__link" href="#top"><i class="fa-regular fa-square-caret-up fa-2xl"></i></a>
            </p>
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
                                <h4>Aucune mesure n'a été enregistrée</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <script>
        // var myColors = [
        //     "#a3f5ff",
        //     "#54ce54",
        //     "#ffff00",
        //     "#ffb800",
        //     "#ff6800",
        //     "#f44242"
        // ];

        // Récupération des données
        var myImc    = document.querySelector("#myImc").value;
        var myWeight = document.querySelector("#myWeight").value;
        var range =  document.querySelector("#range").value;
        var idealWeight = document.querySelector("#idealWeight").value;
        var age = document.querySelector("#age").value;
        var morphoCoefficient = document.querySelector("#morphoCoefficient").value;

        range = JSON.parse(range);
        idealWeight = JSON.parse(idealWeight);

        // Calcul du poids ideal formule de Lorentz et Creff
        var height = idealWeight.height;
        var gender = idealWeight.sexe;
        var coef = NaN;

        if(gender = 'h') {
            coef = 4;
        } else {
            coef = 2.5;
        }

        var lorentz = height - 100 - ((height -150)/coef);
        var creff   = (height - 100 + age/10)*morphoCoefficient;

        for(i=0; i < range.length; i++) {
            range[i] = Math.floor(range[i]*100)/100;
        }

        // Jauge IMC
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

        // Jauge poids actuel
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

        // Jauge poids idéal formule de Lorentz
        var g3 = new JustGage({
            id: "lorentz",
            value: lorentz,
            min: 0,
            max: 200,
            donut: true,
            decimals: 2,
            title: "Poids idéal",
            customSectors: {
                ranges: [{
                    color: "#54ce54",
                    lo: 0,
                    hi: lorentz
                }, {
                    color: "#f44242",
                    lo: lorentz + 0.01,
                    hi: 200
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

        // Jauge poids idéal formule de Creff
        var g4 = new JustGage({
            id: "creff",
            value: creff,
            min: 0,
            max: 200,
            donut: true,
            decimals: 2,
            title: "Poids idéal",
            customSectors: {
                ranges: [{
                    color: "#54ce54",
                    lo: 0,
                    hi: creff
                }, {
                    color: "#f44242",
                    lo: creff + 0.01,
                    hi: 200
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
</x-app-layout>
