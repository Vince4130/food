<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MeasurementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $mesures = DB::table('measurements')
            ->select('date', 'weight', 'height')
            ->join('users', 'users.id', '=', 'measurements.user_id')
            ->where('users.id', $user->id)
            ->orderBy('date', 'desc')
            ->get();

        $tendances = $this->weightTendance($mesures);

        return view('measurements.index', ['user' => $user, 'mesures' => $mesures, 'tendances' => $tendances]);
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
    public function show(Measurement $measurement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Measurement $measurement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Measurement $measurement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Measurement $measurement)
    {
        //
    }

    public function weightTendance($mesures) : Array
    {
        $weights = [];

        $tendances = [];

        foreach($mesures as $mesure) {
            $weights [] = $mesure->weight;
        }
// dd($weights);
        for($i=count($weights) - 1 ; $i > 0; $i--) {
            if($weights[$i] < $weights[$i-1]) {
                $tendances [] = "+";
            } elseif($weights[$i] > $weights[$i-1]) {
                $tendances [] = "-";
            } elseif($weights[$i] == $weights[$i-1]) {
                $tendances [] = "=";
            }
        }

        $tendances = array_reverse($tendances);
        
        array_push($tendances, "N/A");
// dd($tendances);
        return $tendances;
    }
}
