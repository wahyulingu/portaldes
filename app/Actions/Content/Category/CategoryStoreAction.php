<?php

namespace App\Actions\Content\Category;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Moderation;
use App\Models\Content\ContentCategory;
use App\Repositories\Content\ContentCategoryRepository;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

/**
 * @extends Action<ContentCategory>
 */
class CategoryStoreAction extends Action implements RuledActionContract
{
    public function __construct(protected ContentCategoryRepository $contentCategoryRepository)
    {
    }

    public function rules(Collection $payload): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],

            'parent_id' => [
                'sometimes',
                Rule::exists(ContentCategory::class, 'id'),
            ],

            'status' => ['sometimes', Rule::in(Moderation::names())],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return $this->contentCategoryRepository->store($validatedPayload);
    }
}
