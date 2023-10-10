<?php

namespace App\Actions\Sid\Wilayah\RukunWarga;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\Wilayah\SidWilayahRukunWargaRepository;

class RukunWargaIndexAction extends IndexAction
{
    public function __construct(SidWilayahRukunWargaRepository $repository)
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
