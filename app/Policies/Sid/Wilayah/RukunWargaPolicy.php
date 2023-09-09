<?php

namespace App\Policies\Sid\Wilayah;

use App\Models\Sid\Wilayah\SidWilayahRukunWarga;
use App\Models\User;

class RukunWargaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.sid.wilayah.rukunWarga');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SidWilayahRukunWarga $warga): bool
    {
        return $user->can('view.sid.wilayah.rukunWarga');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.sid.wilayah.rukunWarga');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SidWilayahRukunWarga $warga): bool
    {
        return $user->can('update.sid.wilayah.rukunWarga');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SidWilayahRukunWarga $warga): bool
    {
        return $user->can('delete.sid.wilayah.rukunWarga');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SidWilayahRukunWarga $warga): bool
    {
        return $user->can('restore.sid.wilayah.rukunWarga');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SidWilayahRukunWarga $warga): bool
    {
        return $user->can('forceDelete.sid.wilayah.rukunWarga');
    }
}
