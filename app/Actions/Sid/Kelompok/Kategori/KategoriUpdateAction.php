<?php

namespace App\Actions\Sid\Kelompok\Kategori;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\Kelompok\SidKelompokKategori;
use Illuminate\Support\Collection;

/**
 * @extends Action<SidKelompokKategori>
 */
class KategoriUpdateAction extends Action implements RuledActionContract
{
    protected SidKelompokKategori $kategori;

    public function prepare(SidKelompokKategori $kategori)
    {
        return tap($this, fn (self $action) => $action->kategori = $kategori);
    }

    public function rules(Collection $payload): array
    {
        return [
            'nama' => 'sometimes|string',
            'keterangan' => 'sometimes|string',
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return $this->kategori->update($validatedPayload->toArray());
    }
}
