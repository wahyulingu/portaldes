<?php

namespace App\Actions\Sid\Kelompok;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\Kelompok\SidKelompok;
use App\Models\Sid\Kelompok\SidKelompokKategori;
use App\Models\Sid\SidPenduduk;
use App\Repositories\Sid\Kelompok\SidKelompokRepository;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

/**
 * @extends Action<SidKelompok>
 */
class KelompokStoreAction extends Action implements RuledActionContract
{
    public function __construct(protected SidKelompokRepository $sidKelompokRepository)
    {
    }

    public function rules(Collection $payload): array
    {
        return [
            'kategori_id' => ['required', 'integer', Rule::exists(SidKelompokKategori::class, 'id')],
            'ketua_id' => ['required', 'integer', Rule::exists(SidPenduduk::class, 'id')],
            'nama' => 'required|string',
            'keterangan' => 'required|string',
            'kode' => 'required|string',
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return $this->sidKelompokRepository->store($validatedPayload);
    }
}
