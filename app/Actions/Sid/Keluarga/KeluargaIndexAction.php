<?php

namespace App\Actions\Sid\Keluarga;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\SidKeluargaRepository;

class KeluargaIndexAction extends IndexAction
{
    public function __construct(SidKeluargaRepository $repository)
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
