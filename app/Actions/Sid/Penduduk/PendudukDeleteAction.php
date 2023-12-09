<?php

namespace App\Actions\Sid\Penduduk;

use App\Abstractions\Action\Action;
use App\Models\Sid\SidPenduduk;
use App\Repositories\Sid\SidPendudukRepository;

class PendudukDeleteAction extends Action
{
    protected SidPenduduk $penduduk;

    public function __construct(protected readonly SidPendudukRepository $sidPendudukRepository)
    {
    }

    public function prepare(SidPenduduk $penduduk): self
    {
        return tap($this, fn (self $action) => $action->penduduk = $penduduk);
    }

    protected function handler(array $validatedPayload = [], array $payload = []): bool
    {
        return $this->sidPendudukRepository->delete($this->penduduk->getKey());
    }
}
