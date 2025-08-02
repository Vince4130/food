<?php
namespace App\Http\Controllers;

use App\Models\Measurement;
use App\Models\Morphology;
use App\Models\Target;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request, $year = null, $month = null)
    {
        $user = $request->user();

        $firstDay = Carbon::now()->startOfMonth()->format('Y-m-d'); //format('Y-m-01');
        $lastDay  = Carbon::now()->endOfMonth()->format('Y-m-d');

        $currentdate = Carbon::create($year ?? now()->year, $month ?? now()->month, 1);
        $isLeapYear  = $currentdate->isLeapYear();

        $weights = Measurement::getUserWeights($user, $lastDay);
        // dd($weights);
        $prev = $currentdate->copy()->subMonth();
        $next = $currentdate->copy()->addMonth();

        $age = $user->calculateAge();

        $currentMonth  = $this->frenchMonth($firstDay);
        $previousMonth = Carbon::today()->startOfMonth()->subMonth()->format('Y-m-d');
        // dd($previousMonth);
        $mesure = Measurement::getUserLastMesure($user);

        $mesures = Measurement::getUserMesuresOfCurrentMonth($user, $firstDay, $lastDay);

        $morpho = Morphology::getUserMorphology($user);

        $target = Target::getLastTarget($user) ?? null;

        if ($morpho !== null) {
            $morphoCoefficient = $this->getCoeffMorpho($morpho->morpho);
        } else {
            $morphoCoefficient = 0.;
        }

        $imc = $this->calculateImc($mesure);

        $indicator = $this->imcIndicator($imc);

        $weightsRange = $this->weightIndicator($mesure->height ?? 0);

        $mesuresCurrentMonth = $this->getMesuresCurrentMonth($mesures, $firstDay, $lastDay);

        $weightsCurrentMonth = $mesuresCurrentMonth[0];

        $imcsCurrentMonth = $mesuresCurrentMonth[1];

        $firstDayLastMonth = Carbon::create($firstDay)->subMonth()->format('Y-m-d');

        $lastDayLastMonth = Carbon::create($firstDayLastMonth)->endOfMonth()->format('Y-m-d');

        if ($mesure !== null) {

            $lastMonthMesures = Measurement::getuserLastMesurePreviousMonth($user, $firstDayLastMonth, $lastDayLastMonth);

            if ($weightsCurrentMonth[$firstDay] === null) {

                $weightsCurrentMonth[$firstDay] = $lastMonthMesures->weight;
            }

            if ($imcsCurrentMonth[$firstDay] === null && $mesure !== null) {

                $imcsCurrentMonth[$firstDay] = $this->calculateImc($lastMonthMesures);
            }

        }

        $targetWeight = $this->targetWeight($mesure, $target);
        $targetImc    = $this->calculateTargetImc($mesure, $target);

        return view('dashboard', [
            'user'                => $user,
            'imc'                 => $imc,
            'indicator'           => $indicator,
            'mesure'              => $mesure,
            'weightsCurrentMonth' => $weightsCurrentMonth,
            'imcsCurrentMonth'    => $imcsCurrentMonth,
            'weightsRange'        => $weightsRange,
            'targetWeight'        => $targetWeight,
            'targetImc'           => $targetImc,
            'age'                 => $age,
            'morpho'              => $morpho,
            'morphoCoefficient'   => $morphoCoefficient,
            'currentMonth'        => $currentMonth,
            'previousMonth'       => $previousMonth,
            'weights'             => $weights,
            'prev'                => $prev,
            'next'                => $next,
        ]);
    }

        
    /**
     * calculateTargetImc
     *
     * @param  mixed $mesure
     * @param  mixed $target
     * @return float
     */
    public function calculateTargetImc($mesure, $target = null): float
    {
        $imc = 0.;

        if ($mesure !== null && $mesure->height !== 0) {
            if($target !== null) {
                $weight = $mesure->weight + $target->weight;
                $imc = round($weight / ($mesure->height * $mesure->height) * 10000, 2);
            }
        }

        return $imc;
    }
    
    
    /**
     * calculateImc
     *
     * @param  mixed $mesure
     * @return float
     */
    public function calculateImc($mesure): float
    {
        $imc = 0.;

        if ($mesure !== null && $mesure->height !== 0) {
            $imc = round($mesure->weight / ($mesure->height * $mesure->height) * 10000, 2);
        }

        return $imc;
    }

    /**
     * imcIndicator
     * Retourne le libellé correspondant
     * à l'imc
     *
     * @param  mixed $imc
     * @return string
     */
    public function imcIndicator(float $imc): string
    {

        $indicator = "";

        if ($imc == 0.) {
            $indicator = "N/A";
        }

        if ($imc > 0 && $imc < 18.5) {
            $indicator = "Maigreur";
        }

        if ($imc >= 18.5 && $imc < 25) {
            $indicator = "Corpulence normale";
        }

        if ($imc >= 25 && $imc < 30) {
            $indicator = "Surpoids";
        }

        if ($imc >= 30 && $imc < 35) {
            $indicator = "Obésité modérée";
        }

        if ($imc >= 35 && $imc < 40) {
            $indicator = "Obésité sévère";
        }

        if ($imc >= 40) {
            $indicator = "Obésité morbide";
        }

        return $indicator;
    }

    /**
     * weightIndicator
     * Retourne un tableau contenant les fourchettes
     * de poids en fonction de celles des imc
     *
     * @param  mixed $height
     * @return array
     */
    public function weightIndicator(int $height): array
    {
        $weights = [];

        $imcRange = [18.5, 25, 30, 35, 40];

        for ($i = 0; $i < count($imcRange); $i++) {

            $weights[] = ($imcRange[$i] * ($height * $height)) / 10000;
        }

        return $weights;
    }

    /**
     * frenchMonth
     * Retourne le mois courant en français
     *
     * @return string
     */
    public function frenchMonth($date): string
    {
        $months = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];

        $mois = Carbon::parse($date)->format('n');

        return $months[$mois - 1];
    }

    /**
     * getMesuresCurrentMonth
     *
     * @param  mixed $mesures
     * @param  mixed $firstDay
     * @param  mixed $lastDay
     * @return void
     */
    public function getMesuresCurrentMonth($mesures, $firstDay, $lastDay)
    {
        $days = CarbonPeriod::create($firstDay, '1 day', $lastDay);

        $daysOfMonth    = [];
        $mesuresOfMonth = [];
        $weightOfDay    = [];
        $imcOfDay       = [];

        foreach ($days as $day) {
            $day               = $day->format('Y-m-d');
            $daysOfMonth[$day] = null;
        }

        $mesures = $mesures->toArray();

        foreach ($mesures as $mesure) {
            $imcOfDay[$mesure->date] = $mesure->weight / ($mesure->height * $mesure->height) * 10000;
        }

        foreach ($mesures as $mesure) {
            $weightOfDay[$mesure->date] = $mesure->weight;
        }

        $weightsOfMonth = array_merge($daysOfMonth, $weightOfDay);
        $imcOfMonth     = array_merge($daysOfMonth, $imcOfDay);

        $mesuresOfMonth = [$weightsOfMonth, $imcOfMonth];

        return $mesuresOfMonth;
    }

    /**
     * getCoeffMorpho
     *
     * @param  mixed $morpho
     * @return float
     */
    public function getCoeffMorpho(string $morpho): float
    {
        $coeff = 0.;

        switch ($morpho) {
            case 'slim':
                $coeff = 0.81;
                break;
            case 'normal':
                $coeff = 0.9;
                break;
            case 'large':
                $coeff = 0.99;
                break;
            default:
                $coeff = 1;
        }

        return $coeff;
    }
    
    
    /**
     * targetWeight
     *
     * @param  mixed $mesure
     * @param  mixed $target
     * @return float
     */
    public function targetWeight($mesure = null, $target = null): float
    {
        $targetWeight = 0;

        if ($mesure !== null) {
            if ($target !== null) {
                $targetWeight = $mesure->weight + $target->weight;
            }
        }

        return $targetWeight;
    }
}
