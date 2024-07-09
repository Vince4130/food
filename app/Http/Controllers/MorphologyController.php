<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use App\Models\Morphology;
use App\Models\User; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Ramsey\Uuid\Type\Integer;

class MorphologyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       $user = $request->user();

       $morphologies = Morphology::getUserAllMorphology($user);

       return view('morphologies.index', ['user' => $user, 'morphologies' => $morphologies]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = $request->user();

        return view('morphologies.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $exist = Morphology::where('date', $request->date)->where('user_id', $request->user_id)->count();
        
        $user = User::find($request->user_id);

        if($exist === 0) {
            $request->validate([
                'date' => ['required', 'date'],
                'morpho' => ['required', 'string'],
                'user_id' => ['required', 'integer'],
            ]);

        
            $morphology = Morphology::create([
                'date' => $request->date,
                'morpho' => $request->morpho,
                'user_id' => $request->user_id,
            ]);
            
            event(new Registered($morphology));
            
            return back()->with('success', 'Morphologie enregistrée.'); 
        } 

        return back()->with('failure', 'Morphologie déjà saisie pour cette date.'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Morphology $morphology)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $userId)
    {
        $user = User::find($userId);

        $morphology = Morphology::getUserMorphology($user);

        return view('morphologies.edit', ['morphology' => $morphology]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Morphology $morphology)
    {
        $morphology->morpho = $request->input('morpho');
        $morphology->date = $request->input('date');
        $morphology->id = $request->input('morphology_id');
        
        $morphology->save();

        return redirect(route('morphologies.edit', $morphology->user_id))->with('success', 'Morphologie mofifiée avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Morphology $morphology)
    {
        //
    }

}
