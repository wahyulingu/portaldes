<?php

namespace App\Actions\Sid\Penduduk\Kelompok;

use App\Abstractions\Action\IndexAction;
use App\Contracts\Action\RuledActionContract;
use App\Repositories\Sid\Penduduk\Kelompok\SidPendudukKelompokRepository;

class KelompokIndexAction extends IndexAction implements RuledActionContract
{
    public function __construct(SidPendudukKelompokRepository $repository)
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
