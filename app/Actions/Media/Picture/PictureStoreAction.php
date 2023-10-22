<?php

namespace App\Actions\Media\Picture;

use App\Abstractions\Action\Action;
use App\Actions\File\FileUploadAction;
use App\Contracts\Action\RuledActionContract;
use App\Contracts\Model\MorphToManyPictures;
use App\Models\Media\MediaPicture;
use App\Repositories\Media\MediaPictureRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends Action<MediaPicture>
 */
class PictureStoreAction extends Action implements RuledActionContract
{
    protected Model $pictureable;

    public function __construct(
        protected MediaPictureRepository $mediaPictureRepository,
        protected FileUploadAction $fileUploadAction
    ) {
    }

    public function prepare(Model $pictureable): self
    {
        $this->pictureable = $pictureable;

        return $this;
    }

    public function rules(array $payload): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'image' => ['required', 'mimes:jpg,jpeg,png'],
            'path' => ['sometimes', 'string', 'max:255'],
        ];
    }

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        $picture = $this->mediaPictureRepository->store($validatedPayload);

        if (isset($this->pictureable) && $this->pictureable instanceof MorphToManyPictures) {
            $this->pictureable->pictures()->save($picture);
        }

        $fileData = [
            'file' => $validatedPayload['image'],
            'name' => sprintf('model %s[%s] file', $picture::class, $picture->getKey()),
            'path' => $validatedPayload['path'] ?: 'media/pictures',
            'description' => 'auto-generated model for media picture file',
        ];

        $this->fileUploadAction->prepare($picture)->execute($fileData);

        return $picture;
    }
}
