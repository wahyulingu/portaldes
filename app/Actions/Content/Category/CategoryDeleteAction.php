<?php

namespace App\Actions\Content\Category;

use App\Abstractions\Action\Action;
use App\Models\Content\ContentCategory;
use App\Repositories\Content\ContentCategoryRepository;

class CategoryDeleteAction extends Action
{
    protected ContentCategory $category;

    public function __construct(protected readonly ContentCategoryRepository $contentCategoryRepository)
    {
    }

    public function prepare(ContentCategory $category): self
    {
        return tap($this, fn (self $action) => $action->category = $category);
    }

    protected function handler(array $validatedPayload = [], array $payload = []): bool
    {
        return $this->contentCategoryRepository->delete($this->category->getKey());
    }
}
