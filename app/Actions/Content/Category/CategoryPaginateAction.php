<?php

namespace App\Actions\Content\Category;

use App\Abstractions\Action\Content\ContentIndexAction;
use App\Contracts\Action\PaginatedIndexContract;
use App\Repositories\Content\ContentCategoryRepository;
use Illuminate\Support\Collection;

class CategoryPaginateAction extends ContentIndexAction implements PaginatedIndexContract
{
    public function __construct(ContentCategoryRepository $repository)
    {
        parent::__construct($repository);
    }

    protected function filters(Collection $payload): array
    {
        $filters = [];

        if ($payload->has('keyword')) {
            $filters['like']['title|description|slug'] = '%'.$payload->get('keyword').'%';
        }

        return $filters;
    }
}
