<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class Target extends Model
{
    use HasFactory;
    

    public static function getAllTargets(User $user): ?Object
    {

        $targets = Target::where('user_id', $user->id)->orderByDesc('startDate')->get();

        return $targets;

    }
    
    
    /**
     * getLastTarget
     *
     * @param  mixed $user
     * @return Object
     */
    public static function getLastTarget(User $user): ?Object
    {

        $target = DB::table('targets')
            ->select('targets.id', 'weight', 'startDate', 'endDate', 'user_id')
            ->join('users', 'users.id', '=', 'targets.user_id')
            ->where('users.id', $user->id)
            ->orderByDesc('id')
            ->first();
        
        return $target;
    }
    
    
    /**
     * existPeriodTarget
     *
     * @param  mixed $user
     * @param  mixed $startDate
     * @param  mixed $endDate
     * @return Object
     */
    public static function existPeriodTarget(User $user, $startDate, $endDate): ?Object
    {
        $dates = DB::table('targets')
            ->select('targets.id', 'weight', 'startDate', 'endDate', 'user_id')
            ->join('users', 'users.id', '=', 'targets.user_id')
            ->where('users.id', $user->id)
            ->whereBetween('startDate', [$startDate, $endDate])
            ->orWhereBetween('endDate', [$startDate, $endDate])
            ->first();
        
        return $dates;
    }
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'weight',
        'startDate',
        'endDate',
        'user_id'
    ];

}
