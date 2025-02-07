<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Karton;
use App\Models\Pacijent;
use Illuminate\Auth\Access\Response;

class KartonPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
         return $user->role === 'sestra';
    }

    public function viewForAnyPatient(User $user, Karton $karton){
        $pacijent = Pacijent::where('user_id', $user->id)->firstOrFail();
        return $user->role === 'doktor' || ($user->role === 'pacijent' && $pacijent->jmbg === $karton->pacijent_jmbg);
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Karton $karton): bool
    {
        $pacijent_jmbg = $karton->pacijent_jmbg;
        $pacijent = Pacijent::where('jmbg', $pacijent_jmbg)->firstOrFail();
        return $user->role === 'doktor' || ($user->role === 'pacijent' && $user->id === $pacijent->user_id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'sestra';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->role === 'sestra';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Karton $karton): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Karton $karton): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Karton $karton): bool
    {
        return false;
    }
}
