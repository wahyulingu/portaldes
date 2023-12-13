<?php

namespace App\Policies\Peta;

use App\Models\Peta\PetaGaris;
use App\Models\User;

class GarisPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.peta.garis');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PetaGaris $garis): bool
    {
        return $user->can('view.peta.garis');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.peta.garis');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PetaGaris $garis): bool
    {
        return $user->can('update.peta.garis');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PetaGaris $garis): bool
    {
        return $user->can('delete.peta.garis');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PetaGaris $garis): bool
    {
        return $user->can('restore.peta.garis');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PetaGaris $garis): bool
    {
        return $user->can('forceDelete.peta.garis');
    }
}
