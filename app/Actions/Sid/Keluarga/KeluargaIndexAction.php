<?php

namespace App\Actions\Sid\Keluarga;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\SidKeluargaRepository;
use Illuminate\Support\Collection;

class KeluargaIndexAction extends IndexAction
{
    public function __construct(SidKeluargaRepository $repository)
    {
        parent::__construct($repository);
    }

    protected function filters(Collection $payload): array
    {
        $filters = [];

        if ($payload->has('keyword')) {
            $filters['like']['anggota.nama|anggota.nik|nomor_kartu_keluarga'] = '%'.$payload->get('keyword').'%';
        }

        return $filters;
    }
}
