<?php

namespace App\Actions\Peta\Titik;

use App\Abstractions\Action\Action;
use App\Models\Peta\PetaTitik;
use App\Repositories\Peta\PetaTitikRepository;

class TitikDeleteAction extends Action
{
    protected PetaTitik $titik;

    public function __construct(
        protected readonly PetaTitikRepository $petaTitikRepository,
        protected readonly GambarDeleteAction $gambarDeleteAction,
    ) {
    }

    public function prepare(PetaTitik $titik)
    {
        $this->titik = $titik;

        return $this;
    }

    protected function handler(array $validatedPayload = [], array $payload = []): bool
    {
        if ($this->titik->gambar()->exists()) {
            $this
                ->gambarDeleteAction
                ->prepare($this->titik->gambar)
                ->execute();
        }

        return $this->petaTitikRepository->delete($this->titik->getKey());
    }
}
