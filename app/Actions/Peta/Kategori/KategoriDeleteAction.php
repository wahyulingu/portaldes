<?php

namespace App\Actions\Peta\Kategori;

use App\Abstractions\Action\Action;
use App\Models\Peta\PetaKategori;
use App\Repositories\Peta\PetaKategoriRepository;
use Illuminate\Support\Collection;

class KategoriDeleteAction extends Action
{
    protected PetaKategori $kategori;

    public function __construct(
        protected readonly PetaKategoriRepository $petaKategoriRepository,
    ) {
    }

    public function prepare(PetaKategori $kategori)
    {
        return tap($this, fn (self $action) => $action->kategori = $kategori);
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        return $this->petaKategoriRepository->delete($this->kategori->getKey());
    }
}
