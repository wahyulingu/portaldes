<?php

namespace App\Actions\Media\Picture;

use App\Abstractions\Action\Action;
use App\Actions\File\FileUploadAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Media\MediaPicture;
use App\Repositories\Media\MediaPictureRepository;
use Illuminate\Support\Facades\DB;

/**
 * @extends Action<MediaPicture>
 */
class PictureStoreAction extends Action implements RuledActionContract
{
    public function __construct(
        protected MediaPictureRepository $mediaPictureRepository,
        protected FileUploadAction $fileUploadAction
    ) {
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
        return DB::transaction(
            fn () => tap(
                $this->mediaPictureRepository->store($validatedPayload),
                function (MediaPicture $picture) use ($validatedPayload) {
                    $fileData = [
                        'file' => $validatedPayload['image'],
                        'name' => sprintf('model %s[%s] file', $picture::class, $picture->getKey()),
                        'path' => $validatedPayload['path'] ?: 'media/pictures',
                        'description' => 'auto-generated model for media picture file',
                    ];

                    $picture->file()->save($this->fileUploadAction->execute($fileData));
                }
            )
        );
    }
}
