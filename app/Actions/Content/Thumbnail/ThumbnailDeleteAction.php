<?php

namespace App\Actions\Content\Thumbnail;

use App\Abstractions\Action\Action;
use App\Actions\Media\Picture\PictureDeleteAction;
use App\Models\Content\ContentThumbnail;
use App\Repositories\Content\ContentThumbnailRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ThumbnailDeleteAction extends Action
{
    protected ContentThumbnail $thumbnail;

    public function __construct(
        protected readonly ContentThumbnailRepository $contentThumbnailRepository,
        protected readonly PictureDeleteAction $pictureDeleteAction,
    ) {
    }

    public function prepare(ContentThumbnail $thumbnail)
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

            return $this->contentThumbnailRepository->delete($this->thumbnail->getKey());
        });
    }
}
