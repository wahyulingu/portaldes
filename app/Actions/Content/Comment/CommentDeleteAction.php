<?php

namespace App\Actions\Content\Comment;

use App\Abstractions\Action\Action;
use App\Models\Content\ContentComment;
use App\Repositories\Content\ContentCommentRepository;

class CommentDeleteAction extends Action
{
    protected ContentComment $comment;

    public function __construct(protected readonly ContentCommentRepository $contentCommentRepository)
    {
    }

    public function prepare(ContentComment $comment)
    {
        return tap($this, fn (self $action) => $action->comment = $comment);
    }

    protected function handler(array $validatedPayload = [], array $payload = []): bool
    {
        return $this->contentCommentRepository->delete($this->comment->getKey());
    }
}
