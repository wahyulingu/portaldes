<?php

namespace App\Actions\Content\Page;

use App\Abstractions\Action\Content\ContentIndexAction;
use App\Repositories\Content\ContentPageRepository;

class PageIndexAction extends ContentIndexAction
{
    public function __construct(ContentPageRepository $repository)
    {
        parent::__construct($repository);
    }
}
