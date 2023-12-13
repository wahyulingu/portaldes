<?php

namespace App\Actions\Peta\Garis;

use App\Abstractions\Action\Action;
use App\Actions\Peta\Gambar\GambarStoreAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Peta\PetaGaris;
use App\Models\User;
use App\Repositories\Peta\PetaGarisRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @extends Action<PetaGaris>
 */
class GarisStoreAction extends Action implements RuledActionContract
{
    protected User $user;

    public function __construct(
        readonly protected PetaGarisRepository $petaGarisRepository,
        readonly protected GambarStoreAction $gambarStoreAction
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
        return DB::transaction(fn () => tap(
            $this->petaGarisRepository->store($validatedPayload),
            function (PetaGaris $garis) use ($validatedPayload) {
                $this

                    ->gambarStoreAction
                    ->skipAllRules()
                    ->execute(
                        $validatedPayload
                            ->only('nama', 'keterangan', 'gambar')
                            ->put('peta_type', $garis::class)
                            ->put('peta_id', $garis->getKey())
                            ->put('path', 'peta/garis')
                    );
            }
        ));
    }
}
