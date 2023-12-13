<?php

namespace App\Actions\Content\Thumbnail;

use App\Abstractions\Action\Action;
use App\Actions\Media\Picture\PictureStoreAction;
use App\Actions\Media\Picture\PictureUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Content\ContentThumbnail;
use App\Repositories\Content\ContentThumbnailRepository;
use Illuminate\Support\Collection;

/**
 * @extends Action<ContentThumbnail>
 */
class ThumbnailUpdateAction extends Action implements RuledActionContract
{
    protected ContentThumbnail $thumbnail;

    public function __construct(
        readonly protected ContentThumbnailRepository $contentThumbnailRepository,
        readonly protected PictureStoreAction $pictureStoreAction,
        readonly protected PictureUpdateAction $pictureUpdateAction
    ) {
    }

    public function prepare(ContentThumbnail $thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function rules(Collection $payload): array
    {
        return ['image' => ['required', 'mimes:jpg,jpeg,png', 'max:1024']];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        if ($validatedPayload->has('image')) {
            if ($this->thumbnail->picture()->exists()) {
                $this
                    ->pictureUpdateAction
                    ->prepare($this->thumbnail->picture)
                    ->execute($validatedPayload->only('image'));
            } else {
                /**
                 * @var MediaPicture
                 */
                $picture = $this->pictureStoreAction->skipAllRules()->execute([
                    'name' => sprintf('picture model for peta thumbnail %s', $validatedPayload->get('nama')),
                    'description' => sprintf('auto generated picture model for peta thumbnail %s', $validatedPayload->get('nama')),
                    'image' => $validatedPayload->get('image'),
                    'path' => $validatedPayload->get('path', 'content/thumbnail'),
                ]);

                $validatedPayload->put('picture_id', $picture->getKey());
            }

            $validatedPayload->forget('image');
        }

        if ($validatedPayload->isEmpty()) {
            return true;
        }

        return $this

            ->contentThumbnailRepository
            ->update(
                $this->thumbnail->getKey(),
                $validatedPayload->toArray()
            );
    }
}
