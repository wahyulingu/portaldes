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
}
