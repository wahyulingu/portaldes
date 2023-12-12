<?php

namespace App\Actions\Sid\Wilayah\Lingkungan;

use App\Abstractions\Action\IndexAction;
use App\Repositories\Sid\Wilayah\SidWilayahLingkunganRepository;
use Illuminate\Support\Collection;

class LingkunganIndexAction extends IndexAction
{
    public function __construct(SidWilayahLingkunganRepository $repository)
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
