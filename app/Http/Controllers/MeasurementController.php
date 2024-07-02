<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeasurementUpdateRequest;
use App\Models\Measurement;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
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
            ->select('measurements.id', 'date', 'weight', 'height')
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
    public function create(Request $request)
    {
        $user = $request->user();
        $height = DB::table('measurements')
            ->select('height')
            ->join('users', 'users.id', '=', 'measurements.user_id')
            ->where('users.id', $user->id)
            ->first();
// dd($height);
        return view('measurements.create', ['user' => $user, 'height' => $height]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'date' => ['required', 'date'],
            'weight' => ['required', 'decimal:2'],
            'height' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
        ]);

        $measurement = Measurement::create([
            'date' => $request->date,
            'weight' => $request->weight,
            'height' => $request->height,
            'user_id' => $request->user_id,
        ]);

        event(new Registered($measurement));

        return redirect(route('measurements.index', absolute: false));

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
        return view('measurements.edit', ['measurement' => $measurement]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MeasurementUpdateRequest $request, Measurement $measurement): RedirectResponse
    {
        $measurement->date = $request->input('date');
        $measurement->weight = $request->input('weight');
        $measurement->height = $request->input('height');
        $measurement->id = $request->input('measurement_id');

        $measurement->save();

        return redirect(route('measurements.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Measurement $measurement)
    {
        $measurement->delete();

        return redirect(route('measurements.index'));
    }
    
    /**
     * weightTendance
     * Array of weigth tendances +, - , =
     * for gain, loss or stable weight
     *
     * @param  mixed $mesures
     * @return Array
     */
    public function weightTendance($mesures) : Array
    {
        $weights = [];

        $tendances = [];

        foreach($mesures as $mesure) {
            $weights [] = $mesure->weight;
        }

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

        return $tendances;
    }
}
