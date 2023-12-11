<?php

namespace App\Actions\Content\Thumbnail;

use App\Abstractions\Action\Action;
use App\Abstractions\Model\ContentModel;
use App\Actions\Media\Picture\PictureStoreAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Content\ContentThumbnail;
use App\Models\Media\MediaPicture;
use App\Repositories\Content\ContentThumbnailRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @extends Action<ContentThumbnail>
 */
class ThumbnailStoreAction extends Action implements RuledActionContract
{
    protected ContentModel $content;

    public function __construct(
        protected ContentThumbnailRepository $contentThumbnailRepository,
        protected PictureStoreAction $pictureStoreAction
    ) {
    }

    public function prepare(ContentModel $content): self
    {
        return tap($this, fn (self $action) => $action->content = $content);
    }

    public function rules(Collection $payload): array
    {
        return ['thumbnail' => ['required', 'mimes:jpg,jpeg,png', 'max:2048']];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return DB::transaction(
            function () use ($validatedPayload) {
                /**
                 * @var MediaPicture
                 */
                $picture = $this->pictureStoreAction

                ->skipAllRules()
                ->execute([
                        'image' => $validatedPayload->get('thumbnail'),
                        'name' => $validatedPayload->get('thumbnail')->getClientOriginalName(),
                        'path' => 'content/thumbnails',
                        'description' => 'auto-generated model for media thumbnail picture',
                    ]);

                return $this->contentThumbnailRepository->store([
                    'picture_id' => $picture->getKey(),
                    'content_id' => $this->content->getKey(),
                    'content_type' => $this->content::class,
                ]);
            }
        );
    }
}
