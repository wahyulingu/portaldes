<?php

namespace App\Actions\Content\Category;

use App\Models\Content\ContentCategory;

class CategoryChildsPaginateAction extends CategoryPaginateAction
{
    protected ContentCategory $parentCategory;

    public function prepare(ContentCategory $contentCategory)
    {
        return tap($this, fn (self $action) => $action->parentCategory = $contentCategory);
    }

    protected function filters(array $payload = []): array
    {
        return [
            ...parent::filters($payload),

            'parent' => $this->parentCategory,
        ];
    }
}
