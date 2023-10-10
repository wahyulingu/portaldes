<?php

namespace App\Actions\Sid\Wilayah\RukunTetangga;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\Wilayah\SidWilayahRukunTetanggaRepository;

class RukunTetanggaIndexAction extends IndexAction
{
    public function __construct(SidWilayahRukunTetanggaRepository $repository)
    {
        parent::__construct($repository);
    }

    protected function filters(array $payload = []): array
    {
        $filters = [];

        if (!empty($validatedPayload['keyword'])) {
            $filters['nama:'] = '%'.(@$validatedPayload['keyword'] ?: '').'%';
        }

        return $filters;
    }
}
