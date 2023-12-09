<?php

namespace App\Policies\Sid;

use App\Models\Sid\SidPenduduk;
use App\Models\User;

class PendudukPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.sid.penduduk');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SidPenduduk $sidPenduduk): bool
    {
        return $user->can('view.sid.penduduk');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.sid.penduduk');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SidPenduduk $sidPenduduk): bool
    {
        return $user->can('update.sid.penduduk');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SidPenduduk $sidPenduduk): bool
    {
        return $user->can('delete.sid.penduduk');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SidPenduduk $sidPenduduk): bool
    {
        return $user->can('restore.sid.penduduk');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SidPenduduk $sidPenduduk): bool
    {
        return $user->can('forceDelete.sid.penduduk');
    }
}
