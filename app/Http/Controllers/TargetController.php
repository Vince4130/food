<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Measurement;
use App\Models\Target;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;

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
        $target   = Target::getLastTarget($user);
        $targets  = Target::getAllTargets($user);

        $myActivity    = ($activity !== null) ? $this->getActivity($activity->activity) : "";
        $coeffActivity = ($activity !== null) ? $this->getActivityCoeff($activity->activity) : 0;
        
        $age    = $user->calculateAge();
        $gender = $user->sexe;
        
        $metabolism  = $this->mifflinStJeorMetabolim($mesures, $age,  $gender);
        $dailyEnergy = round($metabolism*$coeffActivity, 2);
        
        return view('targets.index', [
            'user' => $user,
            'mesures' => $mesures,
            'activity' => $myActivity,
            'targets' => $targets,
            'target' => $target,
            'metabolism' => $metabolism,
            'age' => $age,
            'gender' => $gender,
            'dailyEnergy' => $dailyEnergy
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = $request->user();

        return view('targets.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $today = Carbon::now()->format('d/m/Y');
        $minPeriod = Carbon::parse($request->startDate)->addWeek()->subDay()->format('Y-m-d');

        $user = User::find($request->user_id);

        $existStart = Target::whereBetween('startDate', [$request->startDate, $request->endDate])->where('user_id', $request->user_id)->count();
        $existEnd   = Target::whereBetween('endDate', [$request->startDate, $request->endDate])->where('user_id', $request->user_id)->count();
        
        $targetDates = Target::getLastTarget($user);

        $existTargetDates = Target::existPeriodTarget($user, $request->startDate, $request->endDate);

        $targetStart = ($existTargetDates !== null) ? Carbon::create($existTargetDates->startDate)->format('d/m/Y') : "";
        $targetEnd   = ($existTargetDates !== null) ? Carbon::create($existTargetDates->endDate)->format('d/m/Y') : "";
    
        if(!$existTargetDates) {
            
            $request->validate([
                'weight' => ['bail', 'required', 'different:0', 'decimal:2'],
                'startDate' => ['bail', 'required', 'after:yesterday'],
                'endDate' => ['bail', 'required', "after:$minPeriod"],
                'user_id' => ['required', 'integer'],
            ],
                [
                    'startDate.after' => "La date de début doit être postérieure ou égale au $today.",
                    'endDate.after'   => "La date de fin doit être au moins une semaine après la date de début.",
                    'weight.decimal' => "Le champs poids doit comporter :decimal décimales.",
            ]);

            $target = Target::create([
                'weight' => $request->weight,
                'startDate' => $request->startDate,
                'endDate' => $request->endDate,
                'user_id' => $request->user_id,
            ]);

            event(new Registered($target));

            return back()->with('success', "Objectif enregistré");
            // redirect(route('targets.index', absolute: false));
        }

        return back()->withInput()->with('period', "Objectif déjà enregistré pour la période du $targetStart au $targetEnd.");

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
        return view('targets.edit', ['target' => $target]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $today = Carbon::now()->format('d/m/Y');
        $minPeriod = Carbon::create($request->startDate)->addWeek()->subDay()->format('Y-m-d');

        $target = Target::find($request->target_id);
        $user   = User::find($target->user_id);
        
        $request->validate([
            'weight' => ['bail', 'required', 'different:0', 'decimal:2'],
            'startDate' => ['bail', 'required', 'after:yesterday'],
            'endDate' => ['bail', 'required', "after:$minPeriod"],
            'user_id' => ['required', 'integer'],
        ],
            [
                'startDate.after' => "La date de début doit être postérieure ou égale au $today.",
                'endDate.after'   => "La date de fin doit être au moins une semaine après la date de début.",
                'weight.decimal' => "Le champs poids doit comporter :decimal décimales.",
        ]);

        $target = Target::where('id', $target->id)
                        ->where('user_id', $user->id)
                        ->update(['startDate' => $request->startDate, 'endDate' => $request->endDate, 'weight' => $request->weight]);
        if ($target) {  
            event(new Registered($target));
            return back()->with('success', "Objectif mis à jour");
            // redirect(route('targets.index', absolute: false));
        } else {
            return back()->withInput()->with('period', "Objectif déjà enregistré pour la période du .");
        }
                
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Target $target)
    {
        Target::destroy($target->id);

        return redirect(route('targets.index'));
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

        $mb = 0.;
       
        if($mesures) {
            $mb = (10*$mesures->weight) + (6.25*$mesures->height) - (5*$age) + $coeff;
        }
            
        return $mb;
    }

    
    /**
     * getActivityCoeff
     *
     * @param  mixed $activity
     * @return float
     */
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
    
    /**
     * getActivity
     *
     * @param  mixed $activity
     * @return string
     */
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
