<?php

namespace App\Policies;

use App\Models\Karton;
use App\Models\User;
use App\Models\Pregled;
use App\Models\Pacijent;
use Illuminate\Auth\Access\Response;

class PregledPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pregled $pregled): bool
    {
        return false;
    }

    public function viewForAnyPatient(User $user, Karton $karton){
        $pacijent = Pacijent::where('user_id', $user->id)->firstOrFail();
        return $user->role === 'doktor' || ($user->role === 'pacijent' && $pacijent->jmbg === $karton->pacijent_jmbg);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'doktor';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pregled $pregled): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pregled $pregled): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Pregled $pregled): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Pregled $pregled): bool
    {
        return false;
    }
}
