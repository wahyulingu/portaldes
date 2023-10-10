<?php

namespace App\Actions\Content\Article\Index;

use App\Abstractions\Action\Content\Index\ContentIndexAction;
use App\Repositories\Content\ContentArticleRepository;

class ArticleIndexAction extends ContentIndexAction
{
    public function __construct(ContentArticleRepository $repository)
    {
        parent::__construct($repository);
    }

    protected function filters(array $payload = []): array
    {
        return [];
    }
}
