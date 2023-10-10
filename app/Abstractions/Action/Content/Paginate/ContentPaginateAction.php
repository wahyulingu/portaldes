<?php

namespace App\Abstractions\Action\Content\Paginate;

use App\Abstractions\Action\IndexAction;
use App\Abstractions\Repository\ContentRepository;
use App\Contracts\Action\PaginatedActionContract;

abstract class ContentPaginateAction extends IndexAction implements PaginatedActionContract
{
    public function __construct(ContentRepository $repository)
    {
        parent::__construct($repository);
    }
}
