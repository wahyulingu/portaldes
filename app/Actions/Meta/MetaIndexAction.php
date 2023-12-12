<?php

namespace App\Actions\Meta;

use App\Abstractions\Action\IndexAction;
use App\Repositories\MetaRepository;
use Illuminate\Support\Collection;

class MetaIndexAction extends IndexAction
{
    public function __construct(readonly protected MetaRepository $repository)
    {
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        $filters = [];

        if ($validatedPayload->has('keyword')) {
            $filters['like']['anggota.nama|anggota.nik|nomor_kartu_keluarga'] = '%'.$validatedPayload->get('keyword').'%';
        }

        return $this->repository->latest($filters)->paginate($validatedPayload->get('limit', 0));
    }
}
