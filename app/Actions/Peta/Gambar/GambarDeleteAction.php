<?php

namespace App\Actions\Peta\Gambar;

use App\Abstractions\Action\Action;
use App\Models\Peta\PetaGambar;
use App\Repositories\Peta\PetaGambarRepository;

class GambarDeleteAction extends Action
{
    protected PetaGambar $gambar;

    public function __construct(
        protected readonly PetaGambarRepository $petaGambarRepository,
        protected readonly GambarDeleteAction $gambarDeleteAction,
    ) {
    }

    public function prepare(PetaGambar $gambar)
    {
        $this->gambar = $gambar;

        return $this;
    }

    protected function handler(array $validatedPayload = [], array $payload = []): bool
    {
        if ($this->gambar->gambar()->exists()) {
            $this
                ->gambarDeleteAction
                ->prepare($this->gambar->gambar)
                ->execute();
        }

        return $this->petaGambarRepository->delete($this->gambar->getKey());
    }
}
