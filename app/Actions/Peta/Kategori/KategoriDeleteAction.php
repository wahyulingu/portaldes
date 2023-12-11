<?php

namespace App\Actions\Peta\Kategori;

use App\Abstractions\Action\Action;
use App\Models\Peta\PetaKategori;
use App\Repositories\Peta\PetaKategoriRepository;

class KategoriDeleteAction extends Action
{
    protected PetaKategori $kategori;

    public function __construct(
        protected readonly PetaKategoriRepository $petaKategoriRepository,
        protected readonly GambarDeleteAction $gambarDeleteAction,
    ) {
    }

    public function prepare(PetaKategori $kategori)
    {
        $this->kategori = $kategori;

        return $this;
    }

    protected function handler(array $validatedPayload = [], array $payload = []): bool
    {
        if ($this->kategori->gambar()->exists()) {
            $this
                ->gambarDeleteAction
                ->prepare($this->kategori->gambar)
                ->execute();
        }

        return $this->petaKategoriRepository->delete($this->kategori->getKey());
    }
}
