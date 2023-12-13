<?php

namespace App\Actions\Sid\Penduduk;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\SidPendudukRepository;
use Illuminate\Support\Collection;

class PendudukIndexAction extends IndexAction
{
    public function __construct(SidPendudukRepository $repository)
    {
        parent::__construct($repository);
    }

    protected function filters(Collection $payload): array
    {
        $filters = [];

        if ($payload->has('keyword')) {
            $filters['like']['nama|nik|nomor_kartu_keluarga'] = '%'.$payload->get('keyword').'%';
        }

        return $filters;
    }
}
