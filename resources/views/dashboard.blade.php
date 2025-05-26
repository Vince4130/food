<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-slate-200">
            {{ __('Dashboard') }} : {{ ($user->pseudo != null) ? $user->pseudo : $user->firstname }} {{ ($mesure !== null) ? $mesure->height/100 : '' }}  {{ ($mesure !== null) ? ' m,' : '' }} {{ $age }} ans, de sexe {{ ($user->sexe == 'h') ? 'masculin' : 'féminin' }}   
        </h2>
    </x-slot>

    @if($mesure !== null)
    <div class="py-12">
        
        <div class="anchor pagination">
            <p class="page-item">
                <a class="page-link anchor__link dark:bg-gray-800 dark:text-slate-200" href="#bottom"><i class="fa-regular fa-square-caret-down fa-2xl"></i></a>
            </p>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:shadow-none">
                <div class="p-6 text-gray-900 dark:bg-gray-800 dark:text-slate-200">
                    {{ __("Vos dernières mesure d'IMC et poids enregistrés : ") }} {{ ($mesure !== null) ? date('d/m/Y', strtotime($mesure->date)) : 'aucune données à ce jour' }}
                </div>
                <div class="dashboard__data dark:bg-gray-800 dark:text-slate-200">
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

                    <div class="imc__legend dark:text-black">
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
                <div class="p-6 text-gray-900 dark:bg-gray-800 dark:text-slate-200">
                    {{ __("Courbe de poids du mois de ") }}
                    <div class="months">
                        <a class="months__links dark:bg-gray-800 dark:text-slate-200" href="{{ route('dashboard', ['year' => $prev->year, 'month' => $prev->month]) }}"><i class="fa-regular fa-square-caret-left fa-xl"></i></a>
                        <a class="months__links dark:bg-gray-800 dark:text-slate-200" href="{{ route('dashboard', ['year' => $next->year, 'month' => $next->month]) }}"><i class="fa-regular fa-square-caret-right fa-xl"></i></a>
                    </div>
                </div>
                <div class="dashboard__data data__weight dark:bg-gray-800">
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
                <div class="p-6 text-gray-900 dark:bg-gray-800 dark:text-slate-200">
                    {{ __("Courbe imc du mois de ") }} {{ $currentMonth }}
                </div>
                <div class="dashboard__data data__imc dark:bg-gray-800 dark:text-slate-200">
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
                <div class="p-6 text-gray-900 dark:bg-gray-800 dark:text-slate-200">
                    {{ __("Calcul poids idéal") }}
                </div>
                <div class="dashboard__idealweight dark:bg-gray-800 dark:text-slate-200">
                    
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
                <a class="page-link anchor__link dark:bg-gray-800 dark:text-slate-200" href="#top"><i class="fa-regular fa-square-caret-up fa-2xl"></i></a>
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

    <x-slot name="footer">
        <div class="footer">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-slate-200">
                @php $version = tagVersion() @endphp
                Version : {{ $version ?? "v1.0.0"}}   
            </h2>
            <div class="font-semibold text-xl text-gray-800 leading-tight dark:text-slate-200">
                <span>Vince&nbsp;<i class="fa-regular fa-copyright"></i>&nbsp;2024&nbsp;All Rights Reserved</span>
            </div>
            <div class="font-semibold text-xl text-gray-800 leading-tight dark:text-slate-200 footer__links">
                <a class="font-semibold text-xl text-gray-800 leading-tight dark:text-slate-200 footer__links--social" href="#"><i class="fa-brands fa-facebook fa-lg"></i></a>
                <a class="font-semibold text-xl text-gray-800 leading-tight dark:text-slate-200 footer__links--social" href="#"><i class="fa-brands fa-x-twitter fa-lg"></i></a>
                <a class="font-semibold text-xl text-gray-800 leading-tight dark:text-slate-200 footer__links--social" href="#"><i class="fa-brands fa-instagram fa-lg"></i></a>
            </div>
        </div>
    </x-slot>
</x-app-layout>
