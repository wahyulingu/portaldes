<?php

namespace App\Actions\Content\Category;

use App\Abstractions\Action\Content\ContentIndexAction;
use App\Contracts\Action\PaginatedIndexContract;
use App\Repositories\Content\ContentCategoryRepository;

class CategoryPaginateAction extends ContentIndexAction implements PaginatedIndexContract
{
    public function __construct(ContentCategoryRepository $repository)
    {
        parent::__construct($repository);
    }

    protected function filters(array $payload = []): array
    {
        $filters = [];

        if (!empty($payload['keyword'])) {
            $filters['title:|description:|slug:'] = '%'.(@$payload['keyword']).'%';
        }

        return $filters;
    }
}
