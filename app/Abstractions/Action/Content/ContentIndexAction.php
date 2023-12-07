<?php

namespace App\Abstractions\Action\Content;

use App\Abstractions\Action\IndexAction;
use App\Abstractions\Repository\ContentRepository;

abstract class ContentIndexAction extends IndexAction
{
    public function __construct(ContentRepository $repository)
    {
        parent::__construct($repository);
    }
}
