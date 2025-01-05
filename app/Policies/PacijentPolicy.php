<?php

namespace App\Policies;

use App\Models\Pacijent;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PacijentPolicy
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
    public function view(User $user,Pacijent $pacijent): bool
    {
        return ($user->role === 'pacijent' && $user->id === $pacijent->user_id);
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
    public function update(User $user, Pacijent $pacijent): bool
    {
        return ($user->role === 'pacijent' && $user->id === $pacijent->user_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Pacijent $pacijent): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Pacijent $pacijent): bool
    {
        return false;
    }
}
