<?php

namespace App\Actions\Peta\Gambar;

use App\Abstractions\Action\Action;
use App\Actions\Media\Picture\PictureStoreAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Media\MediaPicture;
use App\Models\Peta\PetaGambar;
use App\Models\User;
use App\Repositories\Peta\PetaGambarRepository;
use Illuminate\Support\Facades\DB;

/**
 * @extends Action<PetaGambar>
 */
class GambarStoreAction extends Action implements RuledActionContract
{
    protected User $user;

    public function __construct(
        readonly protected PetaGambarRepository $petaGambarRepository,
        readonly protected PictureStoreAction $pictureStoreAction,
    ) {
    }

    public function rules(array $payload): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'keterangan' => ['required', 'string', 'max:255'],
            'gambar' => ['required', 'mimes:jpg,jpeg,png', 'max:2048'],
            'path' => ['sometimes', 'string', 'max:255'],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload): PetaGambar
    {
        return DB::transaction(function () use ($validatedPayload) {
            /**
             * @var MediaPicture
             */
            $picture = $this->pictureStoreAction->skipAllRules()->execute([
                'name' => sprintf('picture model for peta gambar %s', $validatedPayload['nama']),
                'description' => sprintf('auto generated picture model for peta gambar %s', $validatedPayload['nama']),
                'image' => $validatedPayload['gambar'],
                'path' => @$validatedPayload['path'] ?: 'peta/gambar',
            ]);

            $petaGambarPayload = collect($validatedPayload)

                ->except('gambar')
                ->put('picture_id', $picture->getKey());

            return $this->petaGambarRepository->store($petaGambarPayload);
        });
    }
}
