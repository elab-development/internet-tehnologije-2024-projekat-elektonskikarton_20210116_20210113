<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Karton;
use App\Models\Pacijent;
use App\Models\Dijagnoza;
use App\Policies\DijagnozaPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::define('viewForAnyPatient', function (User $user, Karton $karton){
            if($user->role === 'pacijent'){

                $pacijent = Pacijent::findOrFail($user->id);
                if($pacijent->jmbg === $karton->pacijent_jmbg){
                    return true;
                }
                return false;
            }
            if(in_array($user->role, ['doktor', 'sestra'])){
                return true;
            }
            return false;
        });

    }
}
