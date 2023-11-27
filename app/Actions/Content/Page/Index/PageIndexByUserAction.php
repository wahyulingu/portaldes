<?php

namespace App\Actions\Content\Page\Index;

use App\Abstractions\Action\Content\ContentIndexByUserAction;
use App\Repositories\Content\ContentPageRepository;

class PageIndexByUserAction extends ContentIndexByUserAction
{
    public function __construct(ContentPageRepository $repository)
    {
        parent::__construct($repository);
    }
}
