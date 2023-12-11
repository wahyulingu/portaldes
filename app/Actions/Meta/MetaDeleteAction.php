<?php

namespace App\Actions\Meta;

use App\Abstractions\Action\Action;
use App\Models\Meta;
use App\Repositories\MetaRepository;
use Illuminate\Support\Collection;

class MetaDeleteAction extends Action
{
    protected Meta $meta;

    public function __construct(protected readonly MetaRepository $metaRepository)
    {
    }

    public function prepare(Meta $meta): self
    {
        return tap($this, fn (self $action) => $action->meta = $meta);
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        return $this->metaRepository->delete($this->meta->getKey());
    }
}
