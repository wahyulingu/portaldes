<?php

namespace App\Actions\Sid\Kelompok\Kategori;

use App\Abstractions\Action\IndexAction;
use App\Contracts\Action\RuledActionContract;
use App\Repositories\Sid\Kelompok\SidKelompokKategoriRepository;

class KategoriIndexAction extends IndexAction implements RuledActionContract
{
    public function __construct(SidKelompokKategoriRepository $repository)
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
