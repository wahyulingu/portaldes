<?php

namespace App\Actions\Sid\Bantuan;

use App\Abstractions\Action\Action;
use App\Models\Sid\SidBantuan;
use App\Repositories\Sid\SidBantuanRepository;
use Illuminate\Support\Collection;

class BantuanDeleteAction extends Action
{
    protected SidBantuan $bantuan;

    public function __construct(protected readonly SidBantuanRepository $sidBantuanRepository)
    {
    }

    public function prepare(SidBantuan $bantuan): self
    {
        return tap($this, fn (self $action) => $action->bantuan = $bantuan);
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        return $this->sidBantuanRepository->delete($this->bantuan->getKey());
    }
}
