<?php

namespace App\Actions\Peta\Gambar;

use App\Abstractions\Action\Action;
use App\Actions\Media\Picture\PictureStoreAction;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\TipePeta;
use App\Models\Media\MediaPicture;
use App\Models\Peta\PetaGambar;
use App\Models\User;
use App\Repositories\Peta\PetaGambarRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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

    public function rules(Collection $payload): array
    {
        return [
            'peta_type' => ['required', 'string', Rule::enum(TipePeta::class)],
            'peta_id' => ['required', 'string', Rule::exists($payload->get('peta_type'), 'id')],
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
                'description' => sprintf('auto generated picture model for peta gambar %s', $validatedPayload->get('nama')),
                'image' => $validatedPayload->get('gambar'),
                'path' => $validatedPayload->get('path', 'peta/gambar'),
            ]);

            $petaGambarPayload = $validatedPayload

                ->except('gambar')
                ->put('picture_id', $picture->getKey());

            return $this->petaGambarRepository->store($petaGambarPayload);
        });
    }
}
