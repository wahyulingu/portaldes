<?php

namespace App\Actions\Content\Article;

use App\Abstractions\Action\Content\ContentIndexAction;
use App\Repositories\Content\ContentArticleRepository;

class ArticleIndexAction extends ContentIndexAction
{
    public function __construct(ContentArticleRepository $repository)
    {
        parent::__construct($repository);
    }
}
