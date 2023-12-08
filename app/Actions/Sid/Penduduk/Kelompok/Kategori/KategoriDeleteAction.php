<?php

namespace App\Actions\Sid\Penduduk\Kelompok;

use App\Abstractions\Action\Action;
use App\Models\Sid\Penduduk\Kelompok\SidPendudukKelompokKategori;
use App\Repositories\Sid\Penduduk\Kelompok\SidPendudukKelompokKategoriRepository;

class KategoriDeleteAction extends Action
{
    protected SidPendudukKelompokKategori $kategori;

    public function __construct(protected readonly SidPendudukKelompokKategoriRepository $sidKategoriRepository)
    {
    }

    public function prepare(SidPendudukKelompokKategori $kategori): self
    {
        return tap($this, fn (self $action) => $action->kategori = $kategori);
    }

    protected function handler(array $validatedPayload = [], array $payload = []): bool
    {
        return $this->sidKategoriRepository->delete($this->kategori->getKey());
    }
}
