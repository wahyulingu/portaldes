<?php

namespace App\Actions\Content\Category;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Moderation;
use App\Models\Content\ContentCategory;
use App\Repositories\Content\ContentCategoryRepository;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class CategoryUpdateAction extends Action implements RuledActionContract
{
    protected ContentCategory $category;

    public function __construct(protected readonly ContentCategoryRepository $contentCategoryRepository)
    {
    }

    public function prepare(ContentCategory $category)
    {
        return tap($this, fn (self $action) => $action->category = $category);
    }

    public function rules(Collection $payload): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string', 'max:255'],
            'parent_id' => ['sometimes', Rule::exists(ContentCategory::class, 'id')],
            'status' => ['sometimes', Rule::in(Moderation::names())],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        if (empty($validatedPayload)) {
            return true;
        }

        return $this->contentCategoryRepository->update($this->category->getKey(), $validatedPayload);
    }
}
