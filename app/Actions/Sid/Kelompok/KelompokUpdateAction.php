<?php

namespace App\Actions\Sid\Kelompok;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\Kelompok\SidKelompok;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

/**
 * @extends Action<SidKelompok>
 */
class KelompokUpdateAction extends Action implements RuledActionContract
{
    protected SidKelompok $kelompok;

    public function prepare(SidKelompok $kelompok)
    {
        return tap($this, fn (self $action) => $action->kelompok = $kelompok);
    }

    public function rules(Collection $payload): array
    {
        return [
            'kategori_id' => ['sometimes', 'integer', Rule::exists(SidKelompokKategori::class, 'id')],
            'ketua_id' => ['sometimes', 'integer', Rule::exists(SidPenduduk::class, 'id')],
            'nama' => 'sometimes|string',
            'keterangan' => 'sometimes|string',
            'kode' => 'sometimes|string',
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return $this->kelompok->update($validatedPayload->toArray());
    }
}
