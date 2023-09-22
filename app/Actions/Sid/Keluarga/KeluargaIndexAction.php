<?php

namespace App\Actions\Sid\Keluarga;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\SidKeluargaRepository;

class KeluargaIndexAction extends IndexAction
{
    public function __construct(readonly protected SidKeluargaRepository $repository)
    {
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        $filters = [];

        if (!empty($validatedPayload['keyword'])) {
            $filters['anggota.nama:|anggota.nik:|nomor_kartu_keluarga:'] = '%'.(@$validatedPayload['keyword'] ?: '').'%';
        }

        return $this->repository->index(
            $filters,
            paginate: @$validatedPayload['limit'] ?: 0
        );
    }
}
