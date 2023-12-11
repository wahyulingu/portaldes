<?php

namespace App\Actions\Peta\Warna;

use App\Abstractions\Action\Action;
use App\Models\Peta\PetaWarna;
use App\Repositories\Peta\PetaWarnaRepository;

class WarnaDeleteAction extends Action
{
    protected PetaWarna $warna;

    public function __construct(
        protected readonly PetaWarnaRepository $petaWarnaRepository,
        protected readonly GambarDeleteAction $gambarDeleteAction,
    ) {
    }

    public function prepare(PetaWarna $warna)
    {
        $this->warna = $warna;

        return $this;
    }

    protected function handler(array $validatedPayload = [], array $payload = []): bool
    {
        if ($this->warna->gambar()->exists()) {
            $this
                ->gambarDeleteAction
                ->prepare($this->warna->gambar)
                ->execute();
        }

        return $this->petaWarnaRepository->delete($this->warna->getKey());
    }
}
