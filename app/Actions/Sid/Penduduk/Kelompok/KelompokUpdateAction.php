<?php

namespace App\Actions\Sid\Penduduk\Kelompok;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\Penduduk\Kelompok\SidPendudukKelompok;
use Illuminate\Validation\Rule;

/**
 * @extends Action<SidPendudukKelompok>
 */
class KelompokUpdateAction extends Action implements RuledActionContract
{
    protected SidPendudukKelompok $kelompok;

    public function prepare(SidPendudukKelompok $kelompok)
    {
        return tap($this, fn (self $action) => $action->kelompok = $kelompok);
    }

    public function rules(array $payload): array
    {
        return [
            'kategori_id' => ['sometimes', 'integer', Rule::exists(SidPendudukKelompokKategori::class, 'id')],
            'ketua_id' => ['sometimes', 'integer', Rule::exists(SidPenduduk::class, 'id')],
            'nama' => 'sometimes|string',
            'keterangan' => 'sometimes|string',
            'kode' => 'sometimes|string',
        ];
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        return $this->kelompok->update($validatedPayload);
    }
}
