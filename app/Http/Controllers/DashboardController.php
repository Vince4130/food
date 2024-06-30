<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Measurement;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Decimal;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $mesure = DB::table('measurements')
            ->select('measurements.id', 'date', 'weight', 'height')
            ->join('users', 'users.id', '=', 'measurements.user_id')
            ->where('users.id', $user->id)
            ->first();
        
        $imc = $this->calculateImc($mesure);

        $indicator = $this->imcIndicator($imc);

        return view('dashboard', ['imc' => $imc, 'indicator' => $indicator, 'mesure' => $mesure]);   
    }


    public function calculateImc($mesure): float
    {
        $imc = $mesure->weight/($mesure->height*$mesure->height)*10000;
        return $imc;
    }

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
        
}
