<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = $request->user();

        return view('activities.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $exist = Activity::where('date', $request->date)->where('user_id', $request->user_id)->count();
        
        $user = User::find($request->user_id);

        if($exist === 0) {
            $request->validate([
                'date' => ['required', 'date'],
                'activity' => ['required', 'string'],
                'user_id' => ['required', 'integer'],
            ]);

        
            $activity = Activity::create([
                'date' => $request->date,
                'activity' => $request->activity,
                'user_id' => $request->user_id,
            ]);
            
            event(new Registered($activity));
            
            return back()->with('success', 'Niveau d\'activité physique enregistré.'); 
        } 

        return back()->with('failure', 'Niveau d\'activité physique déjà saisi pour cette date.'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        // $user = User::find($userId);

        $myActivity = Activity::find($activity->id);

        return view('activities.edit', ['activity' => $myActivity]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        $activity->activity = $request->input('activity');
        $activity->date = $request->input('date');
        $activity->id = $request->input('activity_id');
        
        $activity->save();

        return redirect(route('activities.edit', $activity->id))->with('success', 'Niveau d\'activité physique mofifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        //
    }
}
