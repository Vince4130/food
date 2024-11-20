<?php

namespace App\Providers;

use App\Models\Morphology;
use App\Models\Activity;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        View::composer('*', function($view) {
            
            $user = Auth::user();
            
            if($user !== null) {
                $existMorpho = false;
                $existActivity = false;
                $userMorphology = Morphology::getUserMorphology($user);
                $userActivityLevel = Activity::getUserActivity($user);
                
                if(isset($userMorphology)) {
                    $existMorpho = true;
                }

                if(isset($userActivityLevel)) {
                    $existActivity = true;
                }
                $view->with(['existMorpho'=> $existMorpho, 'existActivity' => $existActivity, 'userMorphology' => $userMorphology, 'userActivityLevel' => $userActivityLevel]);
            }
        });
    }
}
