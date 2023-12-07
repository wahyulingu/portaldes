<?php

namespace App\Actions\Content\Comment\Index;

use App\Abstractions\Action\Content\ContentIndexAction;
use App\Repositories\Content\ContentCommentRepository;

class CommentIndexAction extends ContentIndexAction
{
    public function __construct(ContentCommentRepository $repository)
    {
        parent::__construct($repository);
    }

    protected function filters(array $payload = []): array
    {
        if (!empty($payload['status'])) {
            return collect($payload)->only('status');
        }

        return [];
    }
}
