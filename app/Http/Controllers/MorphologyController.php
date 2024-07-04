<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use App\Models\Morphology;
use App\Models\User; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
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
    public function edit(int $userId)
    {
        $user = User::find($userId);

        $morphology = Morphology::getUserMorphology($user);

        return view('morphologies.edit', ['morphology' => $morphology]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Morphology $morphology): RedirectResponse
    {
        $morphology->morpho = $request->input('morpho');
        $morphology->date = $request->input('date');
        $morphology->id = $request->input('morphology_id');
        
        $morphology->save();

        return redirect(route('morphologies.edit', $morphology->user_id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Morphology $morphology)
    {
        //
    }

}
