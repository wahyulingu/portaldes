<?php

namespace App\Policies\Sid\Wilayah;

use App\Models\Sid\Wilayah\SidWilayahRukunTetangga;
use App\Models\User;

class RukunTetanggaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.sid.wilayah.rukunTetangga');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SidWilayahRukunTetangga $tetangga): bool
    {
        return $user->can('view.sid.wilayah.rukunTetangga');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.sid.wilayah.rukunTetangga');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SidWilayahRukunTetangga $tetangga): bool
    {
        return $user->can('update.sid.wilayah.rukunTetangga');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SidWilayahRukunTetangga $tetangga): bool
    {
        return $user->can('delete.sid.wilayah.rukunTetangga');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SidWilayahRukunTetangga $tetangga): bool
    {
        return $user->can('restore.sid.wilayah.rukunTetangga');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SidWilayahRukunTetangga $tetangga): bool
    {
        return $user->can('forceDelete.sid.wilayah.rukunTetangga');
    }
}
