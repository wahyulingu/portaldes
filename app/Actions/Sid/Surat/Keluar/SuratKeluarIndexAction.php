<?php

namespace App\Actions\Sid\Surat\Keluar;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\Surat\SidSuratKeluarRepository;

class SuratKeluarIndexAction extends IndexAction
{
    public function __construct(SidSuratKeluarRepository $repository)
    {
        parent::__construct($repository);
    }

    protected function filters(array $payload = []): array
    {
        $filters = [];

        if (!empty($validatedPayload['keyword'])) {
            $filters['klasifikasi.nama|tujuan|short_desc|penduduk.nama:|penduduk.nik:|penduduk.nomor_kartu_keluarga:'] = '%'.(@$validatedPayload['keyword'] ?: '').'%';
        }

        return $filters;
    }
}
