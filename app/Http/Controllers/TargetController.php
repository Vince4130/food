<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Measurement;
use App\Models\Target;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $mesures  = Measurement::getUserLastMesure($user);
        $activity = Activity::getUserActivity($user);

        $myActivity = $this->getActivity($activity->activity);

        $coeffActivity = $this->getActivityCoeff($activity->activity);
        
        $age    = $user->calculateAge();
        $gender = $user->sexe;
        
        $metabolism  = $this->mifflinStJeorMetabolim($mesures, $age,  $gender);
        $dailyEnergy = round($metabolism*$coeffActivity, 2);
        
        return view('targets.index', ['user' => $user, 'mesures' => $mesures, 'activity' => $myActivity, 'metabolism' => $metabolism, 'age' => $age, 'gender' => $gender, 'dailyEnergy' => $dailyEnergy]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Target $target)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Target $target)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Target $target)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Target $target)
    {
        //
    }
    
    /**
     * mifflinStJeorMetabolim
     * Base Metabolism Calcul
     *
     * @param  mixed $mesures
     * @param  mixed $age
     * @param  mixed $gender
     * @return float
     */
    public function mifflinStJeorMetabolim($mesures, int $age, string $gender): float
    {
        $coeff = ($gender == 'h') ? 5 : -161;
       
        $mb = (10*$mesures->weight) + (6.25*$mesures->height) - (5*$age) + $coeff;
        
        return $mb;
    }


    public function getActivityCoeff(string $activity): float
    {
        $coeff = 0.;

        switch($activity) {
            case 'sedentary': 
                $coeff = 1.2;
                break;

            case 'slightly': 
                $coeff = 1.375;
                break;
                    
            case 'moderatly': 
                $coeff = 1.55;
                break;

            case 'very': 
                $coeff = 1.725;
                break;
            
            case 'extremely': 
                $coeff = 1.9;
                break;

        }

        return $coeff;
    }

    public function getActivity(string $activity): string
    {
        $act = "";

        switch($activity) {
            case 'sedentary': 
                $act = "sédentaire";
                break;

            case 'slightly': 
                $act = "légérement actif.ve";
                break;
                    
            case 'moderatly': 
                $act = "modérement actif.ve";
                break;

            case 'very': 
                $act = "très actif.ve";
                break;
            
            case 'extremely': 
                $act = "extrêment actif.ve";
                break;

        }

        return $act;
    }
}
