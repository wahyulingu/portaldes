<?php

namespace App\Actions\Sid\Pamong;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\Pamong\SidPamongRepository;

class PamongIndexAction extends IndexAction
{
    public function __construct(SidPamongRepository $repository)
    {
        parent::__construct($repository);
    }

    protected function filters(array $payload = []): array
    {
        $filters = [];

        if (!empty($validatedPayload['keyword'])) {
            $filters['anggota.nama:|anggota.nik:|nomor_kartu_keluarga:'] = '%'.(@$validatedPayload['keyword'] ?: '').'%';
        }

        return $filters;
    }
}
