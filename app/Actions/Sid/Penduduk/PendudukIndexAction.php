<?php

namespace App\Actions\Sid\Penduduk;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\SidPendudukRepository;

class PendudukIndexAction extends IndexAction
{
    public function __construct(readonly protected SidPendudukRepository $repository)
    {
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        $filters = [];

        if (!empty($validatedPayload['keyword'])) {
            $filters['nama:|nik:|nomor_kartu_keluarga:'] = '%'.(@$validatedPayload['keyword'] ?: '').'%';
        }

        return $this->repository->index(
            $filters,
            paginate: @$validatedPayload['limit'] ?: 0
        );
    }
}
