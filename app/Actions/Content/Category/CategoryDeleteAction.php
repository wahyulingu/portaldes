<?php

namespace App\Actions\Content\Category;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Content\ContentCategory;
use App\Repositories\Content\ContentCategoryRepository;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class CategoryDeleteAction extends Action implements RuledActionContract
{
    protected ContentCategory $category;

    public function __construct(protected readonly ContentCategoryRepository $contentCategoryRepository)
    {
    }

    public function rules(Collection $payload): array
    {
        return ['id' => ['required', Rule::exists(ContentCategory::class)]];
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        return $this->contentCategoryRepository->delete($validatedPayload['id']);
    }
}
