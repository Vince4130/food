<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Measurement;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Decimal;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $birthdate = $user->birth;

        $firstDay   = Carbon::now()->startOfMonth()->format('Y-m-d'); //format('Y-m-01'); 
        $lastDay    = Carbon::now()->endOfMonth()->format('Y-m-d');
        $currentDay = Carbon::now()->format('Y-m-d');

        $age = Carbon::createFromDate($birthdate)->diffInYears($currentDay);
        $age = (int)$age;

        $currentMonth = $this->frenchMonth($firstDay);

        $mesure = DB::table('measurements')
            ->select('measurements.id', 'date', 'weight', 'height', 'sexe')
            ->join('users', 'users.id', '=', 'measurements.user_id')
            ->where('users.id', $user->id)
            ->orderByDesc('date')
            ->first();

        $weights = DB::table('measurements')
            ->select('date', 'weight')
            ->join('users', 'users.id', '=', 'measurements.user_id')
            ->where('users.id', $user->id)
            ->where('date', '>=', $firstDay)
            ->where('date', '<=', $lastDay)
            ->orderBy('date')
            ->get();
    
        $imc = $this->calculateImc($mesure);

        $indicator = $this->imcIndicator($imc);

        $weightsRange   = $this->weightIndicator($mesure->height);

        $weightsCurrentMonth = $this->getWeightsCurrentMonth($weights, $firstDay, $lastDay);

        return view('dashboard', [
            'imc' => $imc,
            'indicator' => $indicator,
            'mesure' => $mesure,
            'weightsCurrentMonth' => $weightsCurrentMonth,
            'weightsRange' => $weightsRange,
            'age' => $age,
            'currentMonth' => $currentMonth
        ]);   
    }

    
    /**
     * calculateImc
     * Calcul l'imc en fonction de la 
     * taille et du poids
     * 
     * @param  mixed $mesure
     * @return float
     */
    public function calculateImc($mesure): float
    {
        $imc = $mesure->weight/($mesure->height*$mesure->height)*10000;
        
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
    public function imcIndicator(float $imc) : string

    {
    
        $indicator = "";

        if($imc < 18.5) {
            $indicator = "Maigreur";
        }

        if($imc >= 18.5 && $imc < 25) {
            $indicator = "Corpulence normale";
        }
        
        if($imc >= 25 && $imc < 30) {
            $indicator = "Surpoids";
        } 
        
        if($imc >= 30 && $imc < 35) {
            $indicator = "Obésité modérée";
        } 
        
        if($imc >= 35 && $imc < 40) {
            $indicator = "Obésité sévère";
        } 
        
        if($imc >= 40) {
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

        for($i=0; $i < count($imcRange); $i++) {
            
            $weights [] = ($imcRange[$i]*($height*$height))/10000;
        }

        return $weights;
    }

    
    /**
     * frenchMonth
     * Retourne le mois courant en français
     *
     * @return string
     */
    public function frenchMonth() : string 
    {
        $months = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];

        $mois = Carbon::now()->format('n');

        return $months[$mois-1];
    } 
    
    /**
     * getWeightsCurrentMonth
     * Retourne un tableau des poids du mois courant
     * 
     * @param  mixed $weights
     * @param  mixed $firstDay
     * @param  mixed $lastDay
     * @return void
     */
    public function getWeightsCurrentMonth($weights, $firstDay, $lastDay)
    {
        $days = CarbonPeriod::create($firstDay, '1 day', $lastDay);

        $daysOfMonth = [];
        $weightOfDay = [];

        foreach($days as $day) {
            $day = $day->format('Y-m-d');
            $daysOfMonth [$day] = null;
        }

        $weights = $weights->toArray();

        foreach($weights as $weight) {
            $weightOfDay [$weight->date] = $weight->weight;
        }
       
        $weightsOfMonth = array_merge($daysOfMonth, $weightOfDay);

        return $weightsOfMonth;
    }

}
