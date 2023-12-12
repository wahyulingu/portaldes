<?php

namespace App\Policies\Peta;

use App\Models\Peta\PetaWarna;
use App\Models\User;

class WarnaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.peta.warna');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PetaWarna $warna): bool
    {
        return $user->can('view.peta.warna');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.peta.warna');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PetaWarna $warna): bool
    {
        return $user->can('update.peta.warna');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PetaWarna $warna): bool
    {
        return $user->can('delete.peta.warna');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PetaWarna $warna): bool
    {
        return $user->can('restore.peta.warna');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PetaWarna $warna): bool
    {
        return $user->can('forceDelete.peta.warna');
    }
}
