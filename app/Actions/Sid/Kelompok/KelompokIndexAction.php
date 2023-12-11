<?php

namespace App\Actions\Sid\Kelompok;

use App\Abstractions\Action\IndexAction;
use App\Contracts\Action\RuledActionContract;
use App\Repositories\Sid\Kelompok\SidKelompokRepository;
use Illuminate\Support\Collection;

class KelompokIndexAction extends IndexAction implements RuledActionContract
{
    public function __construct(SidKelompokRepository $repository)
    {
        parent::__construct($repository);
    }

    protected function filters(Collection $payload): array
    {
        $filters = [];

        if ($payload->has('keyword')) {
            $filters['nama:|nik:|nomor_kartu_keluarga:'] = '%'.$payload->get('keyword').'%';
        }

        return $filters;
    }
}
