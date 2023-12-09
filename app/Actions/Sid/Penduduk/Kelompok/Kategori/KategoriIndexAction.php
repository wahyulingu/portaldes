<?php

namespace App\Actions\Sid\Penduduk\Kelompok\Kategori;

use App\Abstractions\Action\IndexAction;
use App\Contracts\Action\RuledActionContract;
use App\Repositories\Sid\Penduduk\Kelompok\SidPendudukKelompokKategoriRepository;

class KategoriIndexAction extends IndexAction implements RuledActionContract
{
    public function __construct(SidPendudukKelompokKategoriRepository $repository)
    {
        parent::__construct($repository);
    }

    protected function filters(array $payload = []): array
    {
        $filters = [];

        if (!empty($validatedPayload['keyword'])) {
            $filters['nama:|nik:|nomor_kartu_keluarga:'] = '%'.(@$validatedPayload['keyword'] ?: '').'%';
        }

        return $filters;
    }
}
