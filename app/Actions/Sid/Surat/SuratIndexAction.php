<?php

namespace App\Actions\Sid\Surat;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\Surat\SidSuratRepository;
use Illuminate\Support\Collection;

class SuratIndexAction extends IndexAction
{
    public function __construct(SidSuratRepository $repository)
    {
        parent::__construct($repository);
    }

    protected function filters(Collection $payload): array
    {
        $filters = [];

        if ($payload->has('keyword')) {
            $filters['like']['pamong.nama|pamong.nik|pamong.nomor_kartu_keluarga|surat.penduduk.nama|surat.penduduk.nik|surat.penduduk.nomor_kartu_keluarga'] = '%'.$payload->get('keyword').'%';
        }

        return $filters;
    }
}
