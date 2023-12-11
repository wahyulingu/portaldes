<?php

namespace App\Actions\Peta\Area;

use App\Abstractions\Action\Action;
use App\Actions\Peta\Gambar\GambarDeleteAction;
use App\Models\Peta\PetaArea;
use App\Repositories\Peta\PetaAreaRepository;

class AreaDeleteAction extends Action
{
    protected PetaArea $area;

    public function __construct(
        protected readonly PetaAreaRepository $petaAreaRepository,
        protected readonly GambarDeleteAction $gambarDeleteAction,
    ) {
    }

    public function prepare(PetaArea $area)
    {
        $this->area = $area;

        return $this;
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        if ($this->area->gambar()->exists()) {
            $this
                ->gambarDeleteAction
                ->prepare($this->area->gambar)
                ->execute();
        }

        return $this->petaAreaRepository->delete($this->area->getKey());
    }
}
