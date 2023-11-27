<?php

namespace App\Actions\Content\Page\Index;

use App\Abstractions\Action\Content\ContentIndexByCategoryAction;
use App\Repositories\Content\ContentPageRepository;

class PageIndexByCategoryAction extends ContentIndexByCategoryAction
{
    public function __construct(ContentPageRepository $repository)
    {
        parent::__construct($repository);
    }
}
