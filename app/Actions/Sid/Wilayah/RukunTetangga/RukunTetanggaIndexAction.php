<?php

namespace App\Actions\Sid\Wilayah\RukunTetangga;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\Wilayah\SidWilayahRukunTetanggaRepository;
use Illuminate\Support\Collection;

class RukunTetanggaIndexAction extends IndexAction
{
    public function __construct(SidWilayahRukunTetanggaRepository $repository)
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
