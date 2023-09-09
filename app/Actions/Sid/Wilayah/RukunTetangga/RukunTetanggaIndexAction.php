<?php

namespace App\Actions\Sid\Wilayah\RukunTetangga;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\Wilayah\SidWilayahRukunTetanggaRepository;

class RukunTetanggaIndexAction extends IndexAction
{
    public function __construct(readonly protected SidWilayahRukunTetanggaRepository $sidWilayahRukunTetanggaRepository)
    {
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        $filters = [];

        if (!empty($validatedPayload['keyword'])) {
            $filters['nama:'] = '%'.(@$validatedPayload['keyword'] ?: '').'%';
        }

        return $this->sidWilayahRukunTetanggaRepository->index(
            $filters,
            paginate: @$validatedPayload['limit'] ?: 0
        );
    }
}
