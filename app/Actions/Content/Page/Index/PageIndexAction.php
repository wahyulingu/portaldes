<?php

namespace App\Actions\Content\Page\Index;

use App\Abstractions\Action\Content\ContentIndexAction;
use App\Repositories\Content\ContentPageRepository;

class PageIndexAction extends ContentIndexAction
{
    public function __construct(ContentPageRepository $repository)
    {
        parent::__construct($repository);
    }

    protected function filters(array $payload = []): array
    {
        return [];
    }
}
