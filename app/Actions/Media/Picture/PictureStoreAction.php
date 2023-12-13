<?php

namespace App\Actions\Media\Picture;

use App\Abstractions\Action\Action;
use App\Actions\File\FileUploadAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Media\MediaPicture;
use App\Repositories\Media\MediaPictureRepository;
use Illuminate\Support\Collection;
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

    public function rules(Collection $payload): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'image' => ['required', 'mimes:jpg,jpeg,png'],
            'path' => ['sometimes', 'string', 'max:255'],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return DB::transaction(
            fn () => tap(
                $this->mediaPictureRepository->store($validatedPayload),

                function (MediaPicture $picture) use ($validatedPayload) {
                    $fileData = [
                        'file' => $validatedPayload->get('image'),
                        'fileable_id' => $picture->getKey(),
                        'fileable_type' => $picture::class,
                        'name' => sprintf('model %s[%s] file', $picture::class, $picture->getKey()),
                        'path' => $validatedPayload->get('path', 'media/pictures'),
                        'description' => 'auto-generated model for media picture file',
                    ];

                    $file = $this

                        ->fileUploadAction
                        ->skipAllRules()
                        ->execute($fileData);

                    $picture

                        ->file()
                        ->save($file);
                }
            )
        );
    }
}
