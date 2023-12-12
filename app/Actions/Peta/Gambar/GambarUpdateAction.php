<?php

namespace App\Actions\Peta\Gambar;

use App\Abstractions\Action\Action;
use App\Actions\Media\Picture\PictureStoreAction;
use App\Actions\Media\Picture\PictureUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Media\MediaPicture;
use App\Models\Peta\PetaGambar;
use App\Repositories\Peta\PetaGambarRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

class GambarUpdateAction extends Action implements RuledActionContract
{
    protected PetaGambar $gambar;

    public function __construct(
        protected readonly PetaGambarRepository $petaGambarRepository,
        protected readonly PictureStoreAction $pictureStoreAction,
        protected readonly PictureUpdateAction $pictureUpdateAction
    ) {
    }

    public function prepare(PetaGambar $gambar)
    {
        return tap($this, fn (self $action) => $action->gambar = $gambar);
    }

    public function rules(Collection $payload): array
    {
        return [
            'nama' => ['sometimes', 'string', 'max:255'],
            'keterangan' => ['sometimes', 'string', 'max:255'],
            'gambar' => ['sometimes', 'mimes:jpg,jpeg,png', 'max:2048'],
            'path' => ['sometimes', 'string', 'max:255'],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        $petaGambarPayload = collect($validatedPayload);

        if ($petaGambarPayload->has('gambar')) {
            if ($this->gambar->picture()->exists()) {
                $this
                    ->pictureUpdateAction
                    ->prepare($this->gambar->picture)
                    ->execute($petaGambarPayload->only('image'));
            } else {
                /**
                 * @var MediaPicture
                 */
                $picture = $this->pictureStoreAction->skipAllRules()->execute([
                    'name' => sprintf('picture model for peta gambar %s', $validatedPayload['nama']),
                    'description' => sprintf('auto generated picture model for peta gambar %s', $validatedPayload['nama']),
                    'image' => $petaGambarPayload->get('gambar'),
                    'path' => $petaGambarPayload->get('path', 'peta/gambar'),
                ]);

                $petaGambarPayload->put('picture_id', $picture->getKey());
            }

            $petaGambarPayload->forget('gambar');
        }

        if ($petaGambarPayload->isEmpty()) {
            return true;
        }

        return $this

            ->petaGambarRepository
            ->update(
                $this->gambar->getKey(),
                $petaGambarPayload->toArray()
            );
    }

    protected function updatePicture(UploadedFile $image)
    {
        return tap(
            $this
                ->pictureStoreAction
                ->execute(compact('image')),

            fn (MediaPicture $picture) => $this->gambar->picture()($picture)
        );
    }
}
