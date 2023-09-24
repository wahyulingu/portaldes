<?php

namespace App\Policies\Sid;

use App\Models\Sid\Pamong\SidPamong;
use App\Models\User;

class PamongPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.sid.pamong');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SidPamong $sidPamong): bool
    {
        return $user->can('view.sid.pamong');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.sid.pamong');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SidPamong $sidPamong): bool
    {
        return $user->can('update.sid.pamong');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SidPamong $sidPamong): bool
    {
        return $user->can('delete.sid.pamong');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SidPamong $sidPamong): bool
    {
        return $user->can('restore.sid.pamong');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SidPamong $sidPamong): bool
    {
        return $user->can('forceDelete.sid.pamong');
    }
}
