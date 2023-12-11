<?php

namespace App\Actions\Sid\Wilayah\Lingkungan;

use App\Abstractions\Action\Action;
use App\Models\Sid\Wilayah\SidWilayahLingkungan;
use App\Repositories\Sid\Wilayah\SidWilayahLingkunganRepository;
use Illuminate\Support\Collection;

class LingkunganDeleteAction extends Action
{
    protected SidWilayahLingkungan $lingkungan;

    public function __construct(protected readonly SidWilayahLingkunganRepository $sidWilayahLingkunganRepository)
    {
    }

    public function prepare(SidWilayahLingkungan $lingkungan): self
    {
        return tap($this, fn (self $action) => $action->lingkungan = $lingkungan);
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        return $this->sidWilayahLingkunganRepository->delete($this->lingkungan->getKey());
    }
}
