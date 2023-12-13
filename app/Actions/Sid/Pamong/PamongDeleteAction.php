<?php

namespace App\Actions\Sid\Pamong;

use App\Abstractions\Action\Action;
use App\Models\Sid\Pamong\SidPamong;
use App\Repositories\Sid\Pamong\SidPamongRepository;
use Illuminate\Support\Collection;

class PamongDeleteAction extends Action
{
    protected SidPamong $pamong;

    public function __construct(protected readonly SidPamongRepository $sidPamongRepository)
    {
    }

    public function prepare(SidPamong $pamong): self
    {
        return tap($this, fn (self $action) => $action->pamong = $pamong);
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        return $this->sidPamongRepository->delete($this->pamong->getKey());
    }
}
