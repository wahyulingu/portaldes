<?php

namespace App\Actions\Sid\Pamong\Profile;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\Pamong\SidPamongProfileRepository;

class ProfileIndexAction extends IndexAction
{
    public function __construct(readonly protected SidPamongProfileRepository $repository)
    {
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        $filters = [];

        if (!empty($validatedPayload['keyword'])) {
            $filters['like']['anggota.nama|anggota.nik|nomor_kartu_keluarga'] = '%'.(@$validatedPayload['keyword'] ?: '').'%';
        }

        return $this->repository->latest($filters)->paginate(@$validatedPayload['limit'] ?: 0);
    }
}
