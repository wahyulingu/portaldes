<?php

namespace App\Actions\Sid\Penduduk;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\SidPendudukRepository;

class PendudukIndexAction extends IndexAction
{
    public function __construct(SidPendudukRepository $repository)
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
