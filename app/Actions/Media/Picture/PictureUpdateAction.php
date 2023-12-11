<?php

namespace App\Actions\Media\Picture;

use App\Abstractions\Action\Action;
use App\Actions\File\FileUpdateAction;
use App\Actions\File\FileUploadAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Media\MediaPicture;
use App\Repositories\Media\MediaPictureRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

/**
 * @extends Action<MediaPicture>
 */
class PictureUpdateAction extends Action implements RuledActionContract
{
    protected MediaPicture $picture;

    public function __construct(
        protected readonly MediaPictureRepository $mediaPictureRepository,
        protected readonly FileUploadAction $fileUploadAction,
        protected readonly FileUpdateAction $fileUpdateAction
    ) {
    }

    public function prepare(MediaPicture $picture): self
    {
        return tap($this, fn (self $action) => $action->picture = $picture);
    }

    public function rules(Collection $payload): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string', 'max:255'],
            'image' => ['sometimes', 'mimes:jpg,jpeg,png'],
            'path' => ['sometimes', 'string', 'max:255'],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        if ($validatedPayload->has('image')) {
            $this->updateFile($validatedPayload->get('image'), $validatedPayload->get('path', 'media/pictures'));
        }

        return $this->mediaPictureRepository->update($this->picture->getKey(), $validatedPayload);
    }

    protected function updateFile(UploadedFile $file, string $path)
    {
        if ($this->picture->file()->exists()) {
            return $this

                ->fileUpdateAction
                ->prepare($this->picture->file)
                ->execute(compact('file', 'path'));
        }

        return $this

            ->fileUploadAction
            ->execute(payload: [
                ...compact('file', 'path'),

                'name' => sprintf('model %s[%s] file', $this->picture::class, $this->picture->getKey()),
                'description' => 'auto-generated model for missing media picture file',
            ]);
    }
}
