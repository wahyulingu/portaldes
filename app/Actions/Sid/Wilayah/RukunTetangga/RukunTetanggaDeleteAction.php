<?php

namespace App\Actions\Sid\Wilayah\RukunTetangga;

use App\Abstractions\Action\Action;
use App\Models\Sid\Wilayah\SidWilayahRukunTetangga;
use App\Repositories\Sid\Wilayah\SidWilayahRukunTetanggaRepository;
use Illuminate\Support\Collection;

class RukunTetanggaDeleteAction extends Action
{
    protected SidWilayahRukunTetangga $rukunTetangga;

    public function __construct(protected readonly SidWilayahRukunTetanggaRepository $sidWilayahRukunTetanggaRepository)
    {
    }

    public function prepare(SidWilayahRukunTetangga $rukunTetangga): self
    {
        return tap($this, fn (self $action) => $action->rukunTetangga = $rukunTetangga);
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        return $this->sidWilayahRukunTetanggaRepository->delete($this->rukunTetangga->getKey());
    }
}
