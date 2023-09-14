<?php

namespace App\Actions\Sid\Pamong\Profile;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\Pamong\SidPamongProfileRepository;

class ProfileIndexAction extends IndexAction
{
    public function __construct(readonly protected SidPamongProfileRepository $repository)
    {
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        $filters = [];

        if (!empty($validatedPayload['keyword'])) {
            $filters['anggota.nama:|anggota.nik:|no_kk:'] = '%'.(@$validatedPayload['keyword'] ?: '').'%';
        }

        return $this->repository->index(
            $filters,
            paginate: @$validatedPayload['limit'] ?: 0
        );
    }
}
