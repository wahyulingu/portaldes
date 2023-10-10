<?php

namespace App\Actions\Sid\Wilayah\Lingkungan;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\Wilayah\SidWilayahLingkunganRepository;

class LingkunganIndexAction extends IndexAction
{
    public function __construct(SidWilayahLingkunganRepository $repository)
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
