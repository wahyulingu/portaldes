<?php

namespace App\Actions\Sid\Wilayah\RukunWarga;

use App\Abstractions\Action\Action;
use App\Models\Sid\Wilayah\SidWilayahRukunWarga;
use App\Repositories\Sid\Wilayah\SidWilayahRukunWargaRepository;
use Illuminate\Support\Collection;

class RukunWargaDeleteAction extends Action
{
    protected SidWilayahRukunWarga $rukunWarga;

    public function __construct(protected readonly SidWilayahRukunWargaRepository $sidWilayahRukunWargaRepository)
    {
    }

    public function prepare(SidWilayahRukunWarga $rukunWarga): self
    {
        return tap($this, fn (self $action) => $action->rukunWarga = $rukunWarga);
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        return $this->sidWilayahRukunWargaRepository->delete($this->rukunWarga->getKey());
    }
}
