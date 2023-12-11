<?php

namespace App\Actions\Sid\Kelompok;

use App\Abstractions\Action\Action;
use App\Models\Sid\Kelompok\SidKelompok;
use App\Repositories\Sid\Kelompok\SidKelompokRepository;
use Illuminate\Support\Collection;

class KelompokDeleteAction extends Action
{
    protected SidKelompok $kelompok;

    public function __construct(protected readonly SidKelompokRepository $sidKelompokRepository)
    {
    }

    public function prepare(SidKelompok $kelompok): self
    {
        return tap($this, fn (self $action) => $action->kelompok = $kelompok);
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        return $this->sidKelompokRepository->delete($this->kelompok->getKey());
    }
}
