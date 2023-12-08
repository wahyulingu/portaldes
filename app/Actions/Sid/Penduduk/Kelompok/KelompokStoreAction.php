<?php

namespace App\Actions\Sid\Penduduk\Kelompok;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\Penduduk\Kelompok\SidPendudukKelompok;
use App\Models\Sid\Penduduk\Kelompok\SidPendudukKelompokKategori;
use App\Models\Sid\Penduduk\SidPenduduk;
use App\Repositories\Sid\Penduduk\Kelompok\SidPendudukKelompokRepository;
use Illuminate\Validation\Rule;

/**
 * @extends Action<SidPendudukKelompok>
 */
class KelompokStoreAction extends Action implements RuledActionContract
{
    public function __construct(protected SidPendudukKelompokRepository $sidKelompokRepository)
    {
    }

    public function rules(array $payload): array
    {
        return [
            'kategori_id' => ['required', 'integer', Rule::exists(SidPendudukKelompokKategori::class, 'id')],
            'ketua_id' => ['required', 'integer', Rule::exists(SidPenduduk::class, 'id')],
            'nama' => 'required|string',
            'keterangan' => 'required|string',
            'kode' => 'required|string',
        ];
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        return $this->sidKelompokRepository->store($validatedPayload);
    }
}
