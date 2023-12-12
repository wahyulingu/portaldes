<?php

namespace App\Policies\Sid\Peta;

use App\Models\Peta\PetaWarna;
use App\Models\User;

class WarnaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.sid.peta.warna');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PetaWarna $warna): bool
    {
        return $user->can('view.sid.peta.warna');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.sid.peta.warna');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PetaWarna $warna): bool
    {
        return $user->can('update.sid.peta.warna');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PetaWarna $warna): bool
    {
        return $user->can('delete.sid.peta.warna');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PetaWarna $warna): bool
    {
        return $user->can('restore.sid.peta.warna');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PetaWarna $warna): bool
    {
        return $user->can('forceDelete.sid.peta.warna');
    }
}
