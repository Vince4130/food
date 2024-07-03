<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class Morphology extends Model
{
    use HasFactory;


    public static function getUserMorphology(User $user): string
    {
        $morpho = DB::table('morphologies')
            ->select('morpho')
            ->join('users', 'users.id', '=', 'morphologies.user_id')
            ->where('users.id', $user->id)
            ->first();
        
        return $morpho->morpho;
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
