<?php

namespace App\Actions\Content\Article;

use App\Abstractions\Action\Action;
use App\Actions\Content\Thumbnail\ThumbnailDeleteAction;
use App\Models\Content\ContentArticle;
use App\Repositories\Content\ContentArticleRepository;
use Illuminate\Support\Collection;

class ArticleDeleteAction extends Action
{
    protected ContentArticle $article;

    public function __construct(
        protected readonly ContentArticleRepository $contentArticleRepository,
        protected readonly ThumbnailDeleteAction $thumbnailDeleteAction,
    ) {
    }

    public function prepare(ContentArticle $article)
    {
        $this->article = $article;

        return $this;
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        if ($this->article->thumbnail()->exists()) {
            $this
                ->thumbnailDeleteAction
                ->prepare($this->article->thumbnail)
                ->execute();
        }

        return $this->contentArticleRepository->delete($this->article->getKey());
    }
}
