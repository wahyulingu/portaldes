<?php

namespace App\Actions\Content\Page\Index;

use App\Abstractions\Action\Content\Index\ContentIndexAction;
use App\Repositories\Content\ContentPageRepository;

class PageIndexAction extends ContentIndexAction
{
    public function __construct(ContentPageRepository $repository)
    {
        parent::__construct($repository);
    }
}
