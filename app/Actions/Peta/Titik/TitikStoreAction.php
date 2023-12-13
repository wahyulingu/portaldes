<?php

namespace App\Actions\Peta\Titik;

use App\Abstractions\Action\Action;
use App\Actions\Peta\Gambar\GambarStoreAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Peta\PetaTitik;
use App\Models\User;
use App\Repositories\Peta\PetaTitikRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @extends Action<PetaTitik>
 */
class TitikStoreAction extends Action implements RuledActionContract
{
    protected User $user;

    public function __construct(
        readonly protected PetaTitikRepository $petaTitikRepository,
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
            $this->petaTitikRepository->store($validatedPayload),
            function (PetaTitik $titik) use ($validatedPayload) {
                $this

                    ->gambarStoreAction
                    ->skipAllRules()
                    ->execute(
                        $validatedPayload
                            ->only('nama', 'keterangan', 'gambar')
                            ->put('peta_type', $titik::class)
                            ->put('peta_id', $titik->getKey())
                            ->put('path', 'peta/titik')
                    );
            }
        ));
    }
}
