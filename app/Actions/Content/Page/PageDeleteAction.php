<?php

namespace App\Actions\Content\Page;

use App\Abstractions\Action\Action;
use App\Actions\Content\Thumbnail\ThumbnailDeleteAction;
use App\Models\Content\ContentPage;
use App\Repositories\Content\ContentPageRepository;
use Illuminate\Support\Collection;

class PageDeleteAction extends Action
{
    protected ContentPage $page;

    public function __construct(
        protected readonly ContentPageRepository $contentPageRepository,
        protected readonly ThumbnailDeleteAction $thumbnailDeleteAction,
    ) {
    }

    public function prepare(ContentPage $page)
    {
        $this->page = $page;

        return $this;
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        if ($this->page->thumbnail()->exists()) {
            $this
                ->thumbnailDeleteAction
                ->prepare($this->page->thumbnail)
                ->execute();
        }

        return $this->contentPageRepository->delete($this->page->getKey());
    }
}
