<?php

namespace App\Policies\Sid\Surat;

use App\Models\Sid\Surat\SidSurat;
use App\Models\User;

class SuratPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.sid.surat');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SidSurat $sidSurat): bool
    {
        return $user->can('view.sid.surat');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.sid.surat');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SidSurat $sidSurat): bool
    {
        return $user->can('update.sid.surat');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SidSurat $sidSurat): bool
    {
        return $user->can('delete.sid.surat');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SidSurat $sidSurat): bool
    {
        return $user->can('restore.sid.surat');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SidSurat $sidSurat): bool
    {
        return $user->can('forceDelete.sid.surat');
    }
}
