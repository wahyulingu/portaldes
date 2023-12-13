<?php

namespace App\Actions\Content\Comment;

use App\Abstractions\Action\Action;
use App\Abstractions\Model\ContentModel;
use App\Actions\Content\Thumbnail\ThumbnailStoreAction;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Moderation;
use App\Models\Content\ContentComment;
use App\Models\User;
use App\Repositories\Content\ContentCommentRepository;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

/**
 * @extends Action<ContentComment>
 */
class CommentStoreAction extends Action implements RuledActionContract
{
    protected ContentModel $content;

    protected User $user;

    public function __construct(
        protected ContentCommentRepository $contentCommentRepository,
        protected ThumbnailStoreAction $thumbnailStoreAction
    ) {
    }

    public function rules(Collection $payload): array
    {
        return [
            'body' => ['required', 'string'],

            'parent_id' => [
                'sometimes',
                sprintf('exists:%s,id', ContentComment::class),
            ],

            'status' => ['sometimes', Rule::in(Moderation::names())],
        ];
    }

    public function prepare(User $user, ContentModel $content)
    {
        return tap($this, function (self $action) use ($user, $content): void {
            $action->user = $user;
            $action->content = $content;
        });
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return $this->contentCommentRepository->store([
            ...$validatedPayload,
            'user_id' => $this->user->getKey(),
            'content_id' => $this->content->getKey(),
            'content_type' => $this->content::class,
        ]);
    }
}
