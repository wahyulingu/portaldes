<?php

namespace App\Actions\Peta\Titik;

use App\Abstractions\Action\Action;
use App\Actions\Peta\Gambar\GambarDeleteAction;
use App\Models\Peta\PetaTitik;
use App\Repositories\Peta\PetaTitikRepository;
use Illuminate\Support\Collection;

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
        return tap($this, fn (self $action) => $action->titik = $titik);
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
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
