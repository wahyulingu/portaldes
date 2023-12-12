<?php

namespace App\Actions\Peta\Warna;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Peta\PetaWarna;
use App\Models\User;
use App\Repositories\Peta\PetaWarnaRepository;
use Illuminate\Support\Collection;

/**
 * @extends Action<PetaWarna>
 */
class WarnaStoreAction extends Action implements RuledActionContract
{
    protected User $user;

    public function __construct(
        protected PetaWarnaRepository $petaWarnaRepository,
    ) {
    }

    public function rules(Collection $payload): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'keterangan' => ['required', 'string', 'max:255'],
            'kode' => ['required', 'string'],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return $this->petaWarnaRepository->store($validatedPayload);
    }
}
