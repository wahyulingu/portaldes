<?php

namespace App\Actions\Sid\Photo;

use App\Abstractions\Action\Action;
use App\Actions\Media\Picture\PictureStoreAction;
use App\Actions\Media\Picture\PictureUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Sid\SidPhoto;
use App\Repositories\Sid\SidPhotoRepository;
use Illuminate\Http\UploadedFile;

/**
 * @extends Action<SidPhoto>
 */
class PhotoUpdateAction extends Action implements RuledActionContract
{
    protected SidPhoto $thumbnail;

    public function __construct(
        protected SidPhotoRepository $contentPhotoRepository,
        protected PictureStoreAction $pictureStoreAction,
        protected PictureUpdateAction $pictureUpdateAction
    ) {
    }

    public function prepare(SidPhoto $thumbnail)
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
