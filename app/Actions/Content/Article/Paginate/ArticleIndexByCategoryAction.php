<?php

namespace App\Actions\Content\Article\Index;

use App\Abstractions\Action\Content\Index\ContentIndexByCategoryAction;
use App\Repositories\Content\ContentArticleRepository;

class ArticleIndexByCategoryAction extends ContentIndexByCategoryAction
{
    public function __construct(ContentArticleRepository $repository)
    {
        parent::__construct($repository);
    }
}
