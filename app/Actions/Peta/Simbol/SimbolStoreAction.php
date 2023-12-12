<?php

namespace App\Actions\Peta\Simbol;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Peta\PetaSimbol;
use App\Models\User;
use App\Repositories\Peta\PetaSimbolRepository;
use Illuminate\Support\Collection;

/**
 * @extends Action<PetaSimbol>
 */
class SimbolStoreAction extends Action implements RuledActionContract
{
    protected User $user;

    public function __construct(
        protected PetaSimbolRepository $petaSimbolRepository,
    ) {
    }

    public function rules(Collection $payload): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'keterangan' => ['required', 'string', 'max:255'],
            'gambar' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:1024'],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return tap(
            $this->petaSimbolRepository->store($validatedPayload),
            function (PetaSimbol $peta) {
                // if (isset($validatedPayload['gambar'])) {
                //     $this

                //         ->gambarStoreAction
                //         ->prepare($peta)
                //         ->skipAllRules()
                //         ->execute($validatedPayload);
                // }
            }
        );
    }
}
