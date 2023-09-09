<?php

namespace App\Actions\Content\Page;

use App\Abstractions\Action\Action;
use App\Actions\Content\Thumbnail\ThumbnailStoreAction;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Moderation;
use App\Models\Content\ContentCategory;
use App\Models\Content\ContentPage;
use App\Models\User;
use App\Repositories\Content\ContentPageRepository;
use Illuminate\Validation\Rule;

/**
 * @extends Action<ContentPage>
 */
class PageStoreAction extends Action implements RuledActionContract
{
    protected User $user;

    public function __construct(
        protected ContentPageRepository $contentPageRepository,
        protected ThumbnailStoreAction $thumbnailStoreAction
    ) {
    }

    public function rules(array $payload): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'description' => ['required', 'string', 'max:255'],

            'category_id' => [
                'sometimes',
                sprintf('exists:%s,id', ContentCategory::class),
            ],

            'thumbnail' => ['sometimes', 'mimes:jpg,jpeg,png', 'max:1024'],
            'status' => ['sometimes', Rule::in(Moderation::names())],
        ];
    }

    public function prepare(User $user)
    {
        return tap($this, fn (self $action) => $action->user = $user);
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        return tap(
            $this->contentPageRepository->store([...$validatedPayload, 'user_id' => $this->user->getKey()]),
            function (ContentPage $content) use ($validatedPayload) {
                if (isset($validatedPayload['thumbnail'])) {
                    $this->thumbnailStoreAction->prepare($content)->execute(['image' => $validatedPayload['thumbnail']]);
                }
            }
        );
    }
}
