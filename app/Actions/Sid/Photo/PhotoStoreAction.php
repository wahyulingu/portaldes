<?php

namespace App\Actions\Sid\Photo;

use App\Abstractions\Action\Action;
use App\Abstractions\Model\SidModel;
use App\Actions\Media\Picture\PictureStoreAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Media\MediaPicture;
use App\Models\Sid\SidPhoto;
use App\Repositories\Sid\SidPhotoRepository;
use Illuminate\Support\Facades\DB;

/**
 * @extends Action<SidPhoto>
 */
class PhotoStoreAction extends Action implements RuledActionContract
{
    protected SidModel $content;

    public function __construct(
        protected SidPhotoRepository $contentPhotoRepository,
        protected PictureStoreAction $pictureStoreAction
    ) {
    }

    public function prepare(SidModel $content): self
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
                        'image' => $validatedPayload['thumbnail'],
                        'name' => $validatedPayload['thumbnail']->getClientOriginalName(),
                        'path' => 'content/thumbnails',
                        'description' => 'auto-generated model for media thumbnail picture',
                    ]);

                return $this->contentPhotoRepository->store([
                    'picture_id' => $picture->getKey(),
                    'content_id' => $this->content->getKey(),
                    'content_type' => $this->content::class,
                ]);
            }
        );
    }
}
