<?php

namespace App\Abstractions\Action\Content\Index;

use App\Abstractions\Action\IndexAction;
use App\Abstractions\Repository\ContentRepository;

abstract class ContentIndexAction extends IndexAction
{
    public function __construct(protected ContentRepository $repository)
    {
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        $filters = [];

        if (!empty($validatedPayload['keyword'])) {
            $filters['title:|description:|body:'] = '%'.(@$validatedPayload['keyword'] ?: '').'%';
        }

        return $this->repository->index($filters);
    }
}
