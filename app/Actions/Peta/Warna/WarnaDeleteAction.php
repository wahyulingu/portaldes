<?php

namespace App\Actions\Peta\Warna;

use App\Abstractions\Action\Action;
use App\Models\Peta\PetaWarna;
use App\Repositories\Peta\PetaWarnaRepository;
use Illuminate\Support\Collection;

class WarnaDeleteAction extends Action
{
    protected PetaWarna $warna;

    public function __construct(
        protected readonly PetaWarnaRepository $petaWarnaRepository,
    ) {
    }

    public function prepare(PetaWarna $warna)
    {
        $this->warna = $warna;

        return $this;
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        return $this->petaWarnaRepository->delete($this->warna->getKey());
    }
}
