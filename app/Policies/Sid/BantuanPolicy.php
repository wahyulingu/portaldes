<?php

namespace App\Policies\Sid;

use App\Models\Sid\SidBantuan;
use App\Models\User;

class BantuanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.sid.bantuan');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SidBantuan $sidBantuan): bool
    {
        return $user->can('view.sid.bantuan');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.sid.bantuan');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SidBantuan $sidBantuan): bool
    {
        return $user->can('update.sid.bantuan');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SidBantuan $sidBantuan): bool
    {
        return $user->can('delete.sid.bantuan');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SidBantuan $sidBantuan): bool
    {
        return $user->can('restore.sid.bantuan');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SidBantuan $sidBantuan): bool
    {
        return $user->can('forceDelete.sid.bantuan');
    }
}
