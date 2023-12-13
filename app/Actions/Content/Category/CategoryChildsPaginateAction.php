<?php

namespace App\Actions\Content\Category;

use App\Models\Content\ContentCategory;
use Illuminate\Support\Collection;

class CategoryChildsPaginateAction extends CategoryPaginateAction
{
    protected ContentCategory $parentCategory;

    public function prepare(ContentCategory $contentCategory)
    {
        return tap($this, fn (self $action) => $action->parentCategory = $contentCategory);
    }

    protected function filters(Collection $payload): array
    {
        return [
            ...parent::filters($payload),

            'parent' => $this->parentCategory,
        ];
    }
}
