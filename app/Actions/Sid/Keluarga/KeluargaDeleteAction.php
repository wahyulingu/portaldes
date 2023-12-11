<?php

namespace App\Actions\Sid\Keluarga;

use App\Abstractions\Action\Action;
use App\Models\Sid\SidKeluarga;
use App\Repositories\Sid\SidKeluargaRepository;
use Illuminate\Support\Collection;

class KeluargaDeleteAction extends Action
{
    protected SidKeluarga $keluarga;

    public function __construct(protected readonly SidKeluargaRepository $sidKeluargaRepository)
    {
    }

    public function prepare(SidKeluarga $keluarga): self
    {
        return tap($this, fn (self $action) => $action->keluarga = $keluarga);
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        return $this->sidKeluargaRepository->delete($this->keluarga->getKey());
    }
}
