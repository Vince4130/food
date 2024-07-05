<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;

class Morphology extends Model
{
    use HasFactory;
    
    /**
     * getUserAllMorphology
     *
     * @param  mixed $user
     * @return Object
     */
    public static function getUserAllMorphology(User $user): ?Object
    {
        $morphologies = DB::table('morphologies')
            ->select('morphologies.id', 'morpho', 'date', 'user_id')
            ->join('users', 'users.id', '=', 'morphologies.user_id')
            ->where('users.id', $user->id)
            ->orderByDesc('date')
            ->get();
        
        return $morphologies;
    }
    
    /**
     * getUserMorphology
     *
     * @param  mixed $user
     * @return Object
     */
    public static function getUserMorphology(User $user): ?Object
    {
        $morpho = DB::table('morphologies')
            ->select('morphologies.id', 'morpho', 'date', 'user_id')
            ->join('users', 'users.id', '=', 'morphologies.user_id')
            ->where('users.id', $user->id)
            ->orderByDesc('id')
            ->first();
        
        return $morpho;
    }
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'morpho',
        'date',
        'user_id'
    ];
}
