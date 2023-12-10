<?php

namespace App\Actions\Sid\Kelompok\Kategori;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\Kelompok\SidKelompokKategori;
use App\Repositories\Sid\Kelompok\SidKelompokKategoriRepository;

/**
 * @extends Action<SidKelompokKategori>
 */
class KategoriStoreAction extends Action implements RuledActionContract
{
    public function __construct(protected SidKelompokKategoriRepository $sidKelompokKategoriRepository)
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