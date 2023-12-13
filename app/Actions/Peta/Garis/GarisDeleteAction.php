<?php

namespace App\Actions\Peta\Garis;

use App\Abstractions\Action\Action;
use App\Actions\Peta\Gambar\GambarDeleteAction;
use App\Models\Peta\PetaGaris;
use App\Repositories\Peta\PetaGarisRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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
        $this->garis = $garis;

        return $this;
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        return DB::transaction(function () {
            if ($this->garis->gambar()->exists()) {
                $this
                    ->gambarDeleteAction
                    ->prepare($this->garis->gambar)
                    ->execute();
            }

            return $this->petaGarisRepository->delete($this->garis->getKey());
        });
    }
}
