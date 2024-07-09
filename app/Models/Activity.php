<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class Activity extends Model
{
    use HasFactory;


    public static function getUserActivity(User $user): ?Object
    {
        $activity = DB::table('activities')
            ->select('activities.id', 'activity', 'date', 'user_id')
            ->join('users', 'users.id', '=', 'activities.user_id')
            ->where('users.id', $user->id)
            ->orderByDesc('id')
            ->first();
        
        return $activity;
    }



      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'activity',
        'date',
        'user_id'
    ];
}
