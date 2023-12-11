<?php

namespace App\Actions\Content\Article;

use App\Abstractions\Action\Action;
use App\Actions\Content\Thumbnail\ThumbnailStoreAction;
use App\Actions\Content\Thumbnail\ThumbnailUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Moderation;
use App\Models\Content\ContentArticle;
use App\Models\Content\ContentCategory;
use App\Repositories\Content\ContentArticleRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class ArticleUpdateAction extends Action implements RuledActionContract
{
    protected ContentArticle $article;

    public function __construct(
        protected readonly ContentArticleRepository $contentArticleRepository,
        protected readonly ThumbnailStoreAction $thumbnailStoreAction,
        protected readonly ThumbnailUpdateAction $thumbnailUpdateAction
    ) {
    }

    public function prepare(ContentArticle $article)
    {
        return tap($this, fn (self $action) => $action->article = $article);
    }

    public function rules(Collection $payload): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'body' => ['sometimes', 'string'],
            'description' => ['sometimes', 'string', 'max:255'],
            'category_id' => ['sometimes', Rule::exists(ContentCategory::class, 'id')],
            'article' => ['sometimes', 'mimes:jpg,jpeg,png', 'max:1024'],
            'thumbnail' => ['sometimes', 'mimes:jpg,jpeg,png', 'max:1024'],
            'status' => ['sometimes', Rule::in(Moderation::names())],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        if (isset($validatedPayload['thumbnail'])) {
            $this->updateThumbnail($validatedPayload['thumbnail']);

            unset($validatedPayload['thumbnail']);
        }

        if (empty($validatedPayload)) {
            return true;
        }

        return $this->contentArticleRepository->update($this->article->getKey(), $validatedPayload);
    }

    protected function updateThumbnail(UploadedFile $image)
    {
        if ($this->article->thumbnail()->exists()) {
            return $this

                ->thumbnailUpdateAction
                ->prepare($this->article->thumbnail)
                ->execute(compact('image'));
        }

        return $this

            ->thumbnailStoreAction
            ->prepare($this->article)
            ->execute(compact('image'));
    }
}
