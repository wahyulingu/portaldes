<?php

namespace App\Actions\Sid\Surat;

use App\Abstractions\Action\Action;
use App\Models\Sid\Surat\SidSurat;
use App\Repositories\Sid\Surat\SidSuratRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SuratDeleteAction extends Action
{
    protected SidSurat $surat;

    public function __construct(protected readonly SidSuratRepository $sidSuratRepository)
    {
    }

    public function prepare(SidSurat $surat): self
    {
        return tap($this, fn (self $action) => $action->surat = $surat);
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        return DB::transaction(
            fn () => tap(
                $this->sidSuratRepository->delete($this->surat->getKey()),

                fn () => $this

                    ->surat
                    ->surat_type::repository()
                    ->delete($this->surat->surat_id)
            )
        );
    }
}
