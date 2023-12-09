<?php

namespace App\Policies\Sid\Penduduk\Kelompok;

use App\Models\Sid\Penduduk\Kelompok\SidPendudukKelompokKategori;
use App\Models\User;

class KategoriPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.sid.penduduk.kelompok.kategori');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SidPendudukKelompokKategori $kategori): bool
    {
        return $user->can('view.sid.penduduk.kelompok.kategori');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.sid.penduduk.kelompok.kategori');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SidPendudukKelompokKategori $kategori): bool
    {
        return $user->can('update.sid.penduduk.kelompok.kategori');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SidPendudukKelompokKategori $kategori): bool
    {
        return $user->can('delete.sid.penduduk.kelompok.kategori');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SidPendudukKelompokKategori $kategori): bool
    {
        return $user->can('restore.sid.penduduk.kelompok.kategori');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SidPendudukKelompokKategori $kategori): bool
    {
        return $user->can('forceDelete.sid.penduduk.kelompok.kategori');
    }
}
