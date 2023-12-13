<?php

namespace App\Actions\Sid\Photo;

use App\Abstractions\Action\Action;
use App\Actions\Media\Picture\PictureDeleteAction;
use App\Models\Sid\SidPhoto;
use App\Repositories\Sid\SidPhotoRepository;
use Illuminate\Support\Facades\DB;

class PhotoDeleteAction extends Action
{
    protected SidPhoto $thumbnail;

    public function __construct(
        protected readonly SidPhotoRepository $contentPhotoRepository,
        protected readonly PictureDeleteAction $pictureDeleteAction,
    ) {
    }

    public function prepare(SidPhoto $thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        return DB::transaction(function () {
            if ($this->thumbnail->picture()->exists()) {
                $this
                    ->pictureDeleteAction
                    ->prepare($this->thumbnail->picture)
                    ->execute();
            }

            return $this->contentPhotoRepository->delete($this->thumbnail->getKey());
        });
    }
}
