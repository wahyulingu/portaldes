<?php

namespace App\Actions\Sid\Wilayah\RukunWarga;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\Wilayah\SidWilayahRukunWargaRepository;

class RukunWargaIndexAction extends IndexAction
{
    public function __construct(readonly protected SidWilayahRukunWargaRepository $sidWilayahRukunWargaRepository)
    {
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        $filters = [];

        if (!empty($validatedPayload['keyword'])) {
            $filters['nama:'] = '%'.(@$validatedPayload['keyword'] ?: '').'%';
        }

        return $this->sidWilayahRukunWargaRepository->index(
            $filters,
            paginate: @$validatedPayload['limit'] ?: 0
        );
    }
}
