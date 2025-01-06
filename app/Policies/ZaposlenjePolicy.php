<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Karton;
use App\Models\Pacijent;
use App\Models\Zaposlenje;
use Illuminate\Auth\Access\Response;

class ZaposlenjePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'sestra';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Zaposlenje $zaposlenje): bool
    {
        $karton = Karton::findOrFail($zaposlenje->karton_id);
        $pacijent = Pacijent::findOrFail($karton->pacijent_jmbg);
        return $user->role === 'sestra' || ($user->role === 'pacijent' && $user->id === $pacijent->user_id);
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
    public function update(User $user, Zaposlenje $zaposlenje): bool
    {
        return $user->role === 'sestra';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Zaposlenje $zaposlenje): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Zaposlenje $zaposlenje): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Zaposlenje $zaposlenje): bool
    {
        return false;
    }
}
