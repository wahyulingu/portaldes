<?php

namespace App\Actions\Sid\Pamong;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\Pamong\SidPamongRepository;
use Illuminate\Support\Collection;

class PamongIndexAction extends IndexAction
{
    public function __construct(SidPamongRepository $repository)
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
