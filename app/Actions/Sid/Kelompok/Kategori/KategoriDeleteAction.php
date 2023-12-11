<?php

namespace App\Actions\Sid\Kelompok\Kategori;

use App\Abstractions\Action\Action;
use App\Models\Sid\Kelompok\SidKelompokKategori;
use App\Repositories\Sid\Kelompok\SidKelompokKategoriRepository;
use Illuminate\Support\Collection;

class KategoriDeleteAction extends Action
{
    protected SidKelompokKategori $kategori;

    public function __construct(protected readonly SidKelompokKategoriRepository $sidKelompokKategoriRepository)
    {
    }

    public function prepare(SidKelompokKategori $kategori): self
    {
        return tap($this, fn (self $action) => $action->kategori = $kategori);
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        return $this->sidKelompokKategoriRepository->delete($this->kategori->getKey());
    }
}
