<?php

namespace App\Actions\Content\Thumbnail;

use App\Abstractions\Action\Action;
use App\Actions\Media\Picture\PictureStoreAction;
use App\Contracts\Action\RuledActionContract;
use App\Contracts\Model\HasThumbnailContract;
use App\Models\Content\ContentThumbnail;
use App\Repositories\Content\ContentThumbnailRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends Action<ContentThumbnail>
 */
class ThumbnailStoreAction extends Action implements RuledActionContract
{
    protected HasThumbnailContract&Model $content;

    public function __construct(
        protected ContentThumbnailRepository $contentThumbnailRepository,
        protected PictureStoreAction $pictureStoreAction
    ) {
    }

    public function prepare(HasThumbnailContract&Model $content)
    {
        $this->content = $content;

        return $this;
    }

    public function rules(array $payload): array
    {
        return ['image' => ['required', 'mimes:jpg,jpeg,png', 'max:2048']];
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        $thumbnail = $this->contentThumbnailRepository->create($this->content);

        $pictureData = [
            ...$validatedPayload,
            'name' => sprintf('model %s[%s] picture', $thumbnail::class, $thumbnail->getKey()),
            'path' => 'content/thumbnails',
            'description' => 'auto-generated model for content thumbnail picture',
        ];

        $this->pictureStoreAction->prepare($thumbnail)->execute($pictureData);

        return $thumbnail;
    }
}
