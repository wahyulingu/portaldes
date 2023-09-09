<?php

namespace App\Policies\Sid;

use App\Models\Sid\SidKeluarga;
use App\Models\User;

class KeluargaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.sid.keluarga');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SidKeluarga $sidKeluarga): bool
    {
        return $user->can('view.sid.keluarga');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.sid.keluarga');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SidKeluarga $sidKeluarga): bool
    {
        return $user->can('update.sid.keluarga');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SidKeluarga $sidKeluarga): bool
    {
        return $user->can('delete.sid.keluarga');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SidKeluarga $sidKeluarga): bool
    {
        return $user->can('restore.sid.keluarga');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SidKeluarga $sidKeluarga): bool
    {
        return $user->can('forceDelete.sid.keluarga');
    }
}
