<?php

namespace App\Actions\Peta\Gambar;

use App\Abstractions\Action\Action;
use App\Actions\Media\Picture\PictureDeleteAction;
use App\Models\Peta\PetaGambar;
use App\Repositories\Peta\PetaGambarRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GambarDeleteAction extends Action
{
    protected PetaGambar $gambar;

    public function __construct(
        protected readonly PetaGambarRepository $petaGambarRepository,
        protected readonly PictureDeleteAction $pictureDeleteAction,
    ) {
    }

    public function prepare(PetaGambar $gambar)
    {
        $this->gambar = $gambar;

        return $this;
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        return DB::transaction(function () {
            if ($this->gambar->picture()->exists()) {
                $this
                    ->pictureDeleteAction
                    ->prepare($this->gambar->picture)
                    ->execute();
            }

            return $this->petaGambarRepository->delete($this->gambar->getKey());
        });
    }
}
