<?php

namespace App\Policies\Peta;

use App\Models\Peta\PetaSimbol;
use App\Models\User;

class SimbolPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.peta.simbol');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PetaSimbol $simbol): bool
    {
        return $user->can('view.peta.simbol');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.peta.simbol');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PetaSimbol $simbol): bool
    {
        return $user->can('update.peta.simbol');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PetaSimbol $simbol): bool
    {
        return $user->can('delete.peta.simbol');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PetaSimbol $simbol): bool
    {
        return $user->can('restore.peta.simbol');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PetaSimbol $simbol): bool
    {
        return $user->can('forceDelete.peta.simbol');
    }
}
