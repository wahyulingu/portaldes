<?php

namespace App\Actions\Sid\Penduduk\Kelompok;

use App\Abstractions\Action\Action;
use App\Models\Sid\Penduduk\Kelompok\SidPendudukKelompok;
use App\Repositories\Sid\Penduduk\Kelompok\SidPendudukKelompokRepository;

class KelompokDeleteAction extends Action
{
    protected SidPendudukKelompok $kelompok;

    public function __construct(protected readonly SidPendudukKelompokRepository $sidKelompokRepository)
    {
    }

    public function prepare(SidPendudukKelompok $kelompok): self
    {
        return tap($this, fn (self $action) => $action->kelompok = $kelompok);
    }

    protected function handler(array $validatedPayload = [], array $payload = []): bool
    {
        return $this->sidKelompokRepository->delete($this->kelompok->getKey());
    }
}
