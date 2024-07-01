<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Measurement;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Decimal;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $firstDay = Carbon::now()->format('Y-m-01'); 
        $lastDay  = Carbon::createFromFormat('Y-m-d', $firstDay)->endOfMonth()->format('Y-m-d');
        $currentMonth = $this->frenchMonth($firstDay);

        $mesure = DB::table('measurements')
            ->select('measurements.id', 'date', 'weight', 'height')
            ->join('users', 'users.id', '=', 'measurements.user_id')
            ->where('users.id', $user->id)
            ->orderByDesc('date')
            ->first();

        $weights = DB::table('measurements')
        ->select('weight')
        ->join('users', 'users.id', '=', 'measurements.user_id')
        ->where('users.id', $user->id)
        ->where('date', '>=', $firstDay)
        ->where('date', '<=', $lastDay)
        ->orderBy('date')
        ->get();
    
        $imc = $this->calculateImc($mesure);

        $indicator = $this->imcIndicator($imc);

        $weightsRange   = $this->weightIndicator($mesure->height);

        return view('dashboard', [
            'imc' => $imc,
            'indicator' => $indicator,
            'mesure' => $mesure,
            'weights' => $weights,
            'weightsRange' => $weightsRange,
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
        $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

        $mois = Carbon::now()->format('n');

        return $months[$mois-1];
    } 
}
