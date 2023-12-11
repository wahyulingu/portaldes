<?php

namespace App\Actions\Meta;

use App\Abstractions\Action\IndexAction;
use App\Repositories\MetaRepository;

class MetaIndexAction extends IndexAction
{
    public function __construct(readonly protected MetaRepository $repository)
    {
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        $filters = [];

        if (!empty($validatedPayload['keyword'])) {
            $filters['anggota.nama:|anggota.nik:|nomor_kartu_keluarga:'] = '%'.(@$validatedPayload['keyword'] ?: '').'%';
        }

        return $this->repository->latest($filters)->paginate(@$validatedPayload['limit'] ?: 0);
    }
}
