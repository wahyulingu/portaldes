<?php

namespace App\Actions\Peta\Garis;

use App\Abstractions\Action\Action;
use App\Actions\Peta\Gambar\GambarDeleteAction;
use App\Models\Peta\PetaGaris;
use App\Repositories\Peta\PetaGarisRepository;
use Illuminate\Support\Collection;

class GarisDeleteAction extends Action
{
    protected PetaGaris $garis;

    public function __construct(
        protected readonly PetaGarisRepository $petaGarisRepository,
        protected readonly GambarDeleteAction $gambarDeleteAction,
    ) {
    }

    public function prepare(PetaGaris $garis)
    {
        return tap($this, fn (self $action) => $action->garis = $garis);
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        if ($this->garis->gambar()->exists()) {
            $this
                ->gambarDeleteAction
                ->prepare($this->garis->gambar)
                ->execute();
        }

        return $this->petaGarisRepository->delete($this->garis->getKey());
    }
}
