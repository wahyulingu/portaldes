<?php

namespace App\Actions\Content\Page;

use App\Abstractions\Action\Action;
use App\Actions\Content\Thumbnail\ThumbnailStoreAction;
use App\Actions\Content\Thumbnail\ThumbnailUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Moderation;
use App\Models\Content\ContentCategory;
use App\Models\Content\ContentPage;
use App\Repositories\Content\ContentPageRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class PageUpdateAction extends Action implements RuledActionContract
{
    protected ContentPage $page;

    public function __construct(
        protected readonly ContentPageRepository $contentPageRepository,
        protected readonly ThumbnailStoreAction $thumbnailStoreAction,
        protected readonly ThumbnailUpdateAction $thumbnailUpdateAction
    ) {
    }

    public function prepare(ContentPage $page)
    {
        return tap($this, fn (self $action) => $action->page = $page);
    }

    public function rules(Collection $payload): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'body' => ['sometimes', 'string'],
            'description' => ['sometimes', 'string', 'max:255'],
            'category_id' => ['sometimes', Rule::exists(ContentCategory::class, 'id')],
            'page' => ['sometimes', 'mimes:jpg,jpeg,png', 'max:1024'],
            'thumbnail' => ['sometimes', 'mimes:jpg,jpeg,png', 'max:1024'],
            'status' => ['sometimes', Rule::in(Moderation::names())],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        if ($validatedPayload->has('thumbnail')) {
            $this->updateThumbnail($validatedPayload->get('thumbnail'));

            $validatedPayload->forget('thumbnail');
        }

        if (empty($validatedPayload)) {
            return true;
        }

        return $this->contentPageRepository->update($this->page->getKey(), $validatedPayload);
    }

    protected function updateThumbnail(UploadedFile $image)
    {
        if ($this->page->thumbnail()->exists()) {
            return $this

                ->thumbnailUpdateAction
                ->prepare($this->page->thumbnail)
                ->execute(compact('image'));
        }

        return $this

            ->thumbnailStoreAction
            ->prepare($this->page)
            ->execute(compact('image'));
    }
}
