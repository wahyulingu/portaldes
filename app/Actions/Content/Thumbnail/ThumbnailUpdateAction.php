<?php

namespace App\Actions\Content\Thumbnail;

use App\Abstractions\Action\Action;
use App\Actions\Media\Picture\PictureStoreAction;
use App\Actions\Media\Picture\PictureUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Content\ContentThumbnail;
use App\Repositories\Content\ContentThumbnailRepository;
use Illuminate\Http\UploadedFile;

/**
 * @extends Action<ContentThumbnail>
 */
class ThumbnailUpdateAction extends Action implements RuledActionContract
{
    protected ContentThumbnail $thumbnail;

    public function __construct(
        protected ContentThumbnailRepository $contentThumbnailRepository,
        protected PictureStoreAction $pictureStoreAction,
        protected PictureUpdateAction $pictureUpdateAction
    ) {
    }

    public function prepare(ContentThumbnail $thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function rules(array $payload): array
    {
        return ['image' => ['required', 'mimes:jpg,jpeg,png', 'max:1024']];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        $this->updatePicture($validatedPayload['image'], 'content/thumbnails');
    }

    protected function updatePicture(UploadedFile $image, string $path)
    {
        if ($this->thumbnail->picture()->exists()) {
            return $this

                ->pictureUpdateAction
                ->prepare($this->thumbnail->picture)
                ->execute(compact('image', 'path'));
        }

        return $this

            ->pictureStoreAction
            ->prepare($this->thumbnail)
            ->execute(payload: [
                ...compact('image', 'path'),

                'name' => sprintf('model %s[%s] media picture', $this->thumbnail::class, $this->thumbnail->getKey()),
                'description' => 'auto-generated model content thumbnail media picture',
            ]);
    }
}
