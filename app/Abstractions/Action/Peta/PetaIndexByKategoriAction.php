<?php

namespace App\Abstractions\Action\Peta;

use App\Models\Peta\PetaKategori;

abstract class PetaIndexByKategoriAction extends PetaIndexAction
{
    protected PetaKategori $kategori;

    public function prepare(PetaKategori $kategori)
    {
        return tap($this, fn (self $action) => $action->kategori = $kategori);
    }

    protected function filters(array $payload = []): array
    {
        return ['kategori' => $this->kategori];
    }
}
