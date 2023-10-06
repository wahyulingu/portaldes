<?php

namespace App\Actions\Content\Category\Index;

use App\Abstractions\Action\Content\Index\ContentIndexAction;
use App\Repositories\Content\ContentCategoryRepository;

class CategoryIndexAction extends ContentIndexAction
{
    public function __construct(ContentCategoryRepository $repository)
    {
        parent::__construct($repository);
    }

    public function rules(array $payload): array
    {
        return [...parent::rules($payload), 'noparentOnly' => 'sometimes|bolean'];
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
