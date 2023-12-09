<?php

namespace App\Actions\Sid\Penduduk\Kelompok\Kategori;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\Penduduk\Kelompok\SidPendudukKelompokKategori;

/**
 * @extends Action<SidPendudukKelompokKategori>
 */
class KategoriUpdateAction extends Action implements RuledActionContract
{
    protected SidPendudukKelompokKategori $kategori;

    public function prepare(SidPendudukKelompokKategori $kategori)
    {
        return tap($this, fn (self $action) => $action->kategori = $kategori);
    }

    public function rules(array $payload): array
    {
        return [
            'nama' => 'sometimes|string',
            'keterangan' => 'sometimes|string',
        ];
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        return $this->kategori->update($validatedPayload);
    }
}
