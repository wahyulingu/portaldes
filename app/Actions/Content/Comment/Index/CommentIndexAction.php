<?php

namespace App\Actions\Content\Comment\Index;

use App\Abstractions\Action\Content\ContentIndexAction;
use App\Repositories\Content\ContentCommentRepository;
use Illuminate\Support\Collection;

class CommentIndexAction extends ContentIndexAction
{
    public function __construct(ContentCommentRepository $repository)
    {
        parent::__construct($repository);
    }

    protected function filters(Collection $payload): array
    {
        if ($payload->has('status')) {
            return $payload->only('status')->toArray();
        }

        return [];
    }
}
