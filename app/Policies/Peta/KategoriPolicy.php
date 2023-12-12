<?php

namespace App\Policies\Peta;

use App\Models\Peta\PetaKategori;
use App\Models\User;

class KategoriPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.peta.kategori');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PetaKategori $kategori): bool
    {
        return $user->can('view.peta.kategori');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.peta.kategori');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PetaKategori $kategori): bool
    {
        return $user->can('update.peta.kategori');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PetaKategori $kategori): bool
    {
        return $user->can('delete.peta.kategori');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PetaKategori $kategori): bool
    {
        return $user->can('restore.peta.kategori');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PetaKategori $kategori): bool
    {
        return $user->can('forceDelete.peta.kategori');
    }
}
