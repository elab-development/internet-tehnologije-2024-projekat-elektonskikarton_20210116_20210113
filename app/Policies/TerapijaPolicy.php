<?php

namespace App\Policies;

use App\Models\Terapija;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TerapijaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role !== 'pacijent';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Terapija $terapija): bool
    {
        return $user->role !== 'pacijent';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Terapija $terapija): bool
    {
        return $user->role === 'admin' || $user->role === 'doktor';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Terapija $terapija): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Terapija $terapija): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Terapija $terapija): bool
    {
        return false;
    }
}
