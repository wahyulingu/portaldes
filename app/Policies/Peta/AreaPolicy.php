<?php

namespace App\Policies\Peta;

use App\Models\Peta\PetaArea;
use App\Models\User;

class AreaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.peta.area');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PetaArea $area): bool
    {
        return $user->can('view.peta.area');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.peta.area');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PetaArea $area): bool
    {
        return $user->can('update.peta.area');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PetaArea $area): bool
    {
        return $user->can('delete.peta.area');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PetaArea $area): bool
    {
        return $user->can('restore.peta.area');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PetaArea $area): bool
    {
        return $user->can('forceDelete.peta.area');
    }
}
