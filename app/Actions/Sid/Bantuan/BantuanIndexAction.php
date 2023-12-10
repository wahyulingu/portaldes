<?php

namespace App\Actions\Sid\Bantuan;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\SidBantuanRepository;

class BantuanIndexAction extends IndexAction
{
    public function __construct(SidBantuanRepository $repository)
    {
        parent::__construct($repository);
    }

    protected function filters(array $payload = []): array
    {
        $filters = [];

        if (!empty($validatedPayload['keyword'])) {
            $filters['anggota.nama:|anggota.nik:|nomor_kartu_bantuan:'] = '%'.(@$validatedPayload['keyword'] ?: '').'%';
        }

        return $filters;
    }
}
