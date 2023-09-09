<?php

namespace App\Abstractions\Action\Content\Index;

use App\Models\Content\ContentCategory;

abstract class ContentIndexByCategoryAction extends ContentIndexAction
{
    protected ContentCategory $category;

    public function prepare(ContentCategory $category)
    {
        return tap($this, fn (self $action) => $action->category = $category);
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        return $this->repository->index(
            filters: [
                'category' => $this->category,
            ],

            paginate: @$validatedPayload['limit'] ?: 0
        );
    }
}
