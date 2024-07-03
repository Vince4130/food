<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use App\Models\Morphology;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;

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

        return redirect(route('dashboard'));
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
    public function edit(Morphology $morpho)
    {
        dd($morpho);
        // $user = $request->user();
        
        // $morphology = Morphology::getUserMorphology($user);

        return view('morphologies.edit', ['morpho' => $morpho]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Morphology $morphology): RedirectResponse
    {
        dd($morphology);
        $morphology->morpho = $request->input('morpho');
        $morphology->date = $request->input('date');
        $morphology->user_id = $request->input('morphology_id');
        
        $morphology->save();

        return redirect(route('dashboard'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Morphology $morphology)
    {
        //
    }

}
