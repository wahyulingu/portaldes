<?php

namespace App\Actions\Media\Picture;

use App\Abstractions\Action\Action;
use App\Actions\File\FileDeleteAction;
use App\Models\Media\MediaPicture;
use App\Repositories\Media\MediaPictureRepository;
use Illuminate\Support\Collection;

class PictureDeleteAction extends Action
{
    protected MediaPicture $picture;

    public function __construct(
        protected readonly MediaPictureRepository $contentPictureRepository,
        protected readonly FileDeleteAction $fileDeleteAction
    ) {
    }

    public function prepare(MediaPicture $picture)
    {
        $this->picture = $picture;

        return $this;
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        if ($this->picture->file()->exists()) {
            $this
                ->fileDeleteAction
                ->prepare($this->picture->file)
                ->execute();
        }

        return $this->contentPictureRepository->delete($this->picture->getKey());
    }
}
