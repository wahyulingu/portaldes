<?php

namespace App\Actions\Sid\Surat;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\Surat\SidSuratKeluarRepository;

class SuratKeluarIndexAction extends IndexAction
{
    public function __construct(readonly protected SidSuratKeluarRepository $repository)
    {
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        $filters = [];

        if (!empty($validatedPayload['keyword'])) {
            $filters['klasifikasi.nama|tujuan|short_desc|penduduk.nama:|penduduk.nik:|penduduk.nomor_kartu_keluarga:'] = '%'.(@$validatedPayload['keyword'] ?: '').'%';
        }

        return $this->repository->index(
            $filters,
            paginate: @$validatedPayload['limit'] ?: 0
        );
    }
}
