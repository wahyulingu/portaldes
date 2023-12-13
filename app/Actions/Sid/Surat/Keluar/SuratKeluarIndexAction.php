<?php

namespace App\Actions\Sid\Surat\Keluar;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\Surat\SidSuratKeluarRepository;
use Illuminate\Support\Collection;

class SuratKeluarIndexAction extends IndexAction
{
    public function __construct(SidSuratKeluarRepository $repository)
    {
        parent::__construct($repository);
    }

    protected function filters(Collection $payload): array
    {
        $filters = [];

        if ($payload->has('keyword')) {
            $filters['like']['klasifikasi.nama|tujuan|short_desc|penduduk.nama|penduduk.nik|penduduk.nomor_kartu_keluarga'] = '%'.$payload->get('keyword', '').'%';
        }

        return $filters;
    }
}
