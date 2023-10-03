<?php

namespace App\Actions\Sid\Surat;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\Surat\SidSuratRepository;

class SuratIndexAction extends IndexAction
{
    public function __construct(readonly protected SidSuratRepository $repository)
    {
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        $filters = [];

        if (!empty($validatedPayload['keyword'])) {
            $filters['penduduk.nama:|penduduk.nik:|penduduk.nomor_kartu_keluarga:'] = '%'.(@$validatedPayload['keyword'] ?: '').'%';
        }

        return $this->repository->index(
            $filters,
            paginate: @$validatedPayload['limit'] ?: 0
        );
    }
}
