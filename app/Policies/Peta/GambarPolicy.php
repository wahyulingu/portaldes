<?php

namespace App\Policies\Peta;

use App\Models\Peta\PetaGambar;
use App\Models\User;

class GambarPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.peta.gambar');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PetaGambar $gambar): bool
    {
        return $user->can('view.peta.gambar');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.peta.gambar');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PetaGambar $gambar): bool
    {
        return $user->can('update.peta.gambar');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PetaGambar $gambar): bool
    {
        return $user->can('delete.peta.gambar');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PetaGambar $gambar): bool
    {
        return $user->can('restore.peta.gambar');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PetaGambar $gambar): bool
    {
        return $user->can('forceDelete.peta.gambar');
    }
}
