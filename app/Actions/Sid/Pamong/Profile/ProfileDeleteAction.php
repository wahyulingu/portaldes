<?php

namespace App\Actions\Sid\Pamong\Profile;

use App\Abstractions\Action\Action;
use App\Models\Sid\Pamong\SidPamongProfile;
use App\Repositories\Sid\Pamong\SidPamongProfileRepository;

class ProfileDeleteAction extends Action
{
    protected SidPamongProfile $pamong;

    public function __construct(protected readonly SidPamongProfileRepository $sidPamongRepository)
    {
    }

    public function prepare(SidPamongProfile $pamong): self
    {
        return tap($this, fn (self $action) => $action->pamong = $pamong);
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        return $this->sidPamongRepository->delete($this->pamong->getKey());
    }
}
