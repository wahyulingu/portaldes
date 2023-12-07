<?php

namespace App\Actions\Content\Article;

use App\Abstractions\Action\Action;
use App\Actions\Content\Thumbnail\ThumbnailStoreAction;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Moderation;
use App\Models\Content\ContentArticle;
use App\Models\Content\ContentCategory;
use App\Models\User;
use App\Repositories\Content\ContentArticleRepository;
use Illuminate\Validation\Rule;

/**
 * @extends Action<ContentArticle>
 */
class ArticleStoreAction extends Action implements RuledActionContract
{
    protected User $user;

    public function __construct(
        protected ContentArticleRepository $contentArticleRepository,
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
            $this->contentArticleRepository->store($validatedPayload),
            function (ContentArticle $content) use ($validatedPayload) {
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
