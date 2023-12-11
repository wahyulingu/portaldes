<?php

namespace App\Actions\Sid\Kelompok\Kategori;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\Kelompok\SidKelompokKategori;
use App\Repositories\Sid\Kelompok\SidKelompokKategoriRepository;
use Illuminate\Support\Collection;

/**
 * @extends Action<SidKelompokKategori>
 */
class KategoriStoreAction extends Action implements RuledActionContract
{
    public function __construct(protected SidKelompokKategoriRepository $sidKelompokKategoriRepository)
    {
    }

    public function rules(Collection $payload): array
    {
        return [
            'nama' => 'required|string',
            'keterangan' => 'required|string',
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return $this->sidKelompokKategoriRepository->store($validatedPayload);
    }
}
