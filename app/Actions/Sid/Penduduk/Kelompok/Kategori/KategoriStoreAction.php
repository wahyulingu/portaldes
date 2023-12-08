<?php

namespace App\Actions\Sid\Penduduk\Kelompok;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\Penduduk\Kelompok\SidPendudukKelompokKategori;
use App\Repositories\Sid\Penduduk\Kelompok\SidPendudukKelompokKategoriRepository;

/**
 * @extends Action<SidPendudukKelompokKategori>
 */
class KategoriStoreAction extends Action implements RuledActionContract
{
    public function __construct(protected SidPendudukKelompokKategoriRepository $sidKelompokKategoriRepository)
    {
    }

    public function rules(array $payload): array
    {
        return [
            'nama' => 'required|string',
            'keterangan' => 'required|string',
        ];
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        return $this->sidKelompokKategoriRepository->store($validatedPayload);
    }
}
