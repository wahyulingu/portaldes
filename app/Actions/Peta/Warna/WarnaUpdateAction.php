<?php

namespace App\Actions\Peta\Warna;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Peta\PetaWarna;
use App\Repositories\Peta\PetaWarnaRepository;
use Illuminate\Support\Collection;

class WarnaUpdateAction extends Action implements RuledActionContract
{
    protected PetaWarna $warna;

    public function __construct(
        protected readonly PetaWarnaRepository $petaWarnaRepository
    ) {
    }

    public function prepare(PetaWarna $warna)
    {
        return tap($this, fn (self $action) => $action->warna = $warna);
    }

    public function rules(Collection $payload): array
    {
        return [
            'nama' => ['sometimes', 'string', 'max:255'],
            'keterangan' => ['sometimes', 'string', 'max:255'],
            'kode' => ['sometimes', 'string'],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        return $this->petaWarnaRepository->update($this->warna->getKey(), $validatedPayload);
    }
}
