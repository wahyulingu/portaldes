<?php

namespace App\Actions\Content\Article\Index;

use App\Abstractions\Action\Content\Index\ContentIndexByUserAction;
use App\Repositories\Content\ContentArticleRepository;

class ArticleIndexByUserAction extends ContentIndexByUserAction
{
    public function __construct(ContentArticleRepository $repository)
    {
        parent::__construct($repository);
    }
}
