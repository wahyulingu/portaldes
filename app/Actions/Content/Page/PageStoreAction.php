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

            'user_id' => [
                'required',
                Rule::exists(User::class, 'id'),
            ],

            'category_id' => [
                'sometimes',
                Rule::exists(ContentCategory::class, 'id'),
            ],

            'status' => [
                'sometimes',
                Rule::in(Moderation::names()),
            ],

            'thumbnail' => ['sometimes', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        return tap(
            $this->contentPageRepository->store($validatedPayload),
            function (ContentPage $content) use ($validatedPayload) {
                if (isset($validatedPayload['thumbnail'])) {
                    $this

                        ->thumbnailStoreAction
                        ->prepare($content)
                        ->execute($validatedPayload, skipRules: true);
                }
            }
        );
    }
}
