<?php

namespace App\Abstractions\Action\Content;

use App\Models\Content\ContentCategory;

abstract class ContentIndexByCategoryAction extends ContentIndexAction
{
    protected ContentCategory $category;

    public function prepare(ContentCategory $category)
    {
        return tap($this, fn (self $action) => $action->category = $category);
    }

    protected function filters(array $payload = []): array
    {
        return ['category' => $this->category];
    }
}
