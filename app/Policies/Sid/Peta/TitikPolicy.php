<?php

namespace App\Policies\Sid\Peta;

use App\Models\Peta\PetaTitik;
use App\Models\User;

class TitikPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.sid.peta.titik');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PetaTitik $titik): bool
    {
        return $user->can('view.sid.peta.titik');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.sid.peta.titik');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PetaTitik $titik): bool
    {
        return $user->can('update.sid.peta.titik');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PetaTitik $titik): bool
    {
        return $user->can('delete.sid.peta.titik');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PetaTitik $titik): bool
    {
        return $user->can('restore.sid.peta.titik');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PetaTitik $titik): bool
    {
        return $user->can('forceDelete.sid.peta.titik');
    }
}
