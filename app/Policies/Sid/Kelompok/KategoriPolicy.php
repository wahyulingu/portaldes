<?php

namespace App\Policies\Sid\Kelompok;

use App\Models\Sid\Kelompok\SidKelompokKategori;
use App\Models\User;

class KategoriPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.sid.kelompok.kategori');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SidKelompokKategori $kategori): bool
    {
        return $user->can('view.sid.kelompok.kategori');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.sid.kelompok.kategori');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SidKelompokKategori $kategori): bool
    {
        return $user->can('update.sid.kelompok.kategori');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SidKelompokKategori $kategori): bool
    {
        return $user->can('delete.sid.kelompok.kategori');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SidKelompokKategori $kategori): bool
    {
        return $user->can('restore.sid.kelompok.kategori');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SidKelompokKategori $kategori): bool
    {
        return $user->can('forceDelete.sid.kelompok.kategori');
    }
}
