<?php

namespace App\Actions\Sid\Wilayah\Lingkungan;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\Wilayah\SidWilayahLingkunganRepository;

class LingkunganIndexAction extends IndexAction
{
    public function __construct(readonly protected SidWilayahLingkunganRepository $sidWilayahLingkunganRepository)
    {
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        $filters = [];

        if (!empty($validatedPayload['keyword'])) {
            $filters['nama:'] = '%'.(@$validatedPayload['keyword'] ?: '').'%';
        }

        return $this->sidWilayahLingkunganRepository->index(
            $filters,
            paginate: @$validatedPayload['limit'] ?: 0
        );
    }
}
