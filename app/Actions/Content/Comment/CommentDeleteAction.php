<?php

namespace App\Actions\Content\Comment;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Content\ContentComment;
use App\Repositories\Content\ContentCommentRepository;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class CommentDeleteAction extends Action implements RuledActionContract
{
    protected ContentComment $comment;

    public function __construct(protected readonly ContentCommentRepository $contentCommentRepository)
    {
    }

    public function rules(Collection $payload): array
    {
        return ['id' => ['required', Rule::exists(ContentComment::class)]];
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        return $this->contentCommentRepository->delete($validatedPayload['id']);
    }
}
