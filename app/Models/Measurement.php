<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use PhpParser\Node\Expr\Cast\Object_;
use Ramsey\Uuid\Type\Integer;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use PhpParser\Node\Expr\Cast\Array_;

class Measurement extends Model
{
    use HasFactory;
    
    
    /**
     * getUserAllMesure
     *
     * @param  mixed $user
     * @return Object
     */
    public static function getUserAllMesure(User $user): ?Object
    {
        $mesures = DB::table('measurements')
            ->select('measurements.id', 'date', 'weight', 'height')
            ->join('users', 'users.id', '=', 'measurements.user_id')
            ->where('users.id', $user->id)
            ->orderBy('date', 'desc')
            ->paginate(10);
        
        return $mesures;
    }
    
    /**
     * getUserLastMesure
     *
     * @param  mixed $user
     * @return Object
     */
    public static function getUserLastMesure(User $user): ?Object
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
     * getuserLastMesurePreviousMonth
     *
     * @param  mixed $user
     * @param  mixed $firstDay
     * @param  mixed $lastDay
     * @return Object
     */
    public static function getuserLastMesurePreviousMonth(User $user, string $firstDay, string $lastDay): ?Object
    {
        $mesureOfPreviousMonth = DB::table('measurements')
                        ->select('measurements.id', 'date', 'weight', 'height', 'sexe')
                        ->join('users', 'users.id', '=', 'measurements.user_id')
                        ->where('users.id', $user->id)
                        ->where('date', '>=', $firstDay)
                        ->where('date', '<=', $lastDay)
                        ->orderByDesc('date')
                        ->first();

        if(!$mesureOfPreviousMonth) {
            
            $previousFirstDay = Carbon::create($firstDay)->subMonth()->format('Y-m-d'); 
            $previouslastDay  = Carbon::create($previousFirstDay)->endOfMonth()->format('Y-m-d');
            
            return self::getuserLastMesurePreviousMonth($user, $previousFirstDay, $previouslastDay);
        }

        return $mesureOfPreviousMonth;
    }

       
    /**
     * getUserMesuresOfCurrentMonth
     *
     * @param  mixed $user
     * @param  mixed $firstDay
     * @param  mixed $lastDay
     * @return Object
     */
    public static function getUserMesuresOfCurrentMonth(User $user, string $firstDay, string $lastDay): ?Object
    {
        $mesuresOfMonth = DB::table('measurements')
            ->select('date', 'weight', 'height')
            ->join('users', 'users.id', '=', 'measurements.user_id')
            ->where('users.id', $user->id)
            ->where('date', '>=', $firstDay)
            ->where('date', '<=', $lastDay)
            ->orderBy('date')
            ->get();
        // dd($mesuresOfMonth->count());
        return $mesuresOfMonth;
    }
    
    
    /**
     * getUserHeight
     *
     * @param  mixed $user
     * @return void
     */
    public static function getUserHeight(User $user)
    {
        $height = DB::table('measurements')
            ->select('height')
            ->join('users', 'users.id', '=', 'measurements.user_id')
            ->where('users.id', $user->id)
            ->first();
        
        return $height;
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
