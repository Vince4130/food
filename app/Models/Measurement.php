<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use PhpParser\Node\Expr\Cast\Object_;

class Measurement extends Model
{
    use HasFactory;
    
    /**
     * getUserLastMesure
     *
     * @param  mixed $user
     * @return Object
     */
    public static function getUserLastMesure(User $user): Object
    {
        $mesure = DB::table('measurements')
            ->select('measurements.id', 'date', 'weight', 'height', 'sexe')
            ->join('users', 'users.id', '=', 'measurements.user_id')
            ->where('users.id', $user->id)
            ->orderByDesc('date')
            ->first();

        return $mesure;
    }
    
    /**
     * getUserWeigthsOfCurrentMonth
     *
     * @param  mixed $user
     * @param  mixed $firstDay
     * @param  mixed $lastDay
     * @return void
     */
    public static function getUserMesuresOfCurrentMonth(User $user, string $firstDay, string $lastDay)
    {
        $weights = DB::table('measurements')
            ->select('date', 'weight', 'height')
            ->join('users', 'users.id', '=', 'measurements.user_id')
            ->where('users.id', $user->id)
            ->where('date', '>=', $firstDay)
            ->where('date', '<=', $lastDay)
            ->orderBy('date')
            ->get();

        return $weights;
    }
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'weight',
        'height',
        'date',
        'user_id'
    ];
}
