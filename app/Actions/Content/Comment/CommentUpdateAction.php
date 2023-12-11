<?php

namespace App\Actions\Content\Comment;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Moderation;
use App\Models\Content\ContentComment;
use App\Repositories\Content\ContentCommentRepository;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class CommentUpdateAction extends Action implements RuledActionContract
{
    protected ContentComment $comment;

    public function __construct(protected readonly ContentCommentRepository $contentCommentRepository)
    {
    }

    public function prepare(ContentComment $comment)
    {
        return tap($this, fn (self $action) => $action->comment = $comment);
    }

    public function rules(Collection $payload): array
    {
        return [
            'body' => ['sometimes', 'string', 'max:255'],
            'status' => ['sometimes', Rule::in(Moderation::names())],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        if (empty($validatedPayload)) {
            return true;
        }

        return $this->contentCommentRepository->update($this->comment->getKey(), $validatedPayload);
    }
}
