<?php

namespace App\Actions\Peta\Simbol;

use App\Abstractions\Action\Action;
use App\Actions\Peta\Gambar\GambarDeleteAction;
use App\Models\Peta\PetaSimbol;
use App\Repositories\Peta\PetaSimbolRepository;
use Illuminate\Support\Collection;

class SimbolDeleteAction extends Action
{
    protected PetaSimbol $simbol;

    public function __construct(
        protected readonly PetaSimbolRepository $petaSimbolRepository,
        protected readonly GambarDeleteAction $gambarDeleteAction,
    ) {
    }

    public function prepare(PetaSimbol $simbol)
    {
        return tap($this, fn (self $action) => $action->simbol = $simbol);
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        if ($this->simbol->gambar()->exists()) {
            $this
                ->gambarDeleteAction
                ->prepare($this->simbol->gambar)
                ->execute();
        }

        return $this->petaSimbolRepository->delete($this->simbol->getKey());
    }
}
