<?php

namespace App\Actions\Sid\Wilayah\RukunWarga;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\Wilayah\SidWilayahRukunWargaRepository;
use Illuminate\Support\Collection;

class RukunWargaIndexAction extends IndexAction
{
    public function __construct(SidWilayahRukunWargaRepository $repository)
    {
        parent::__construct($repository);
    }

    protected function filters(Collection $payload): array
    {
        $filters = [];

        if ($payload->has('keyword')) {
            $filters['like']['nama'] = '%'.$payload->get('keyword').'%';
        }

        return $filters;
    }
}
