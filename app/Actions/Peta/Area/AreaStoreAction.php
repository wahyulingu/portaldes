<?php

namespace App\Actions\Peta\Area;

use App\Abstractions\Action\Action;
use App\Actions\Peta\Gambar\GambarStoreAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Peta\PetaArea;
use App\Models\User;
use App\Repositories\Peta\PetaAreaRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @extends Action<PetaArea>
 */
class AreaStoreAction extends Action implements RuledActionContract
{
    protected User $user;

    public function __construct(
        readonly protected PetaAreaRepository $petaAreaRepository,
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
            $this->petaAreaRepository->store($validatedPayload),
            function (PetaArea $area) use ($validatedPayload) {
                $this

                    ->gambarStoreAction
                    ->skipAllRules()
                    ->execute(
                        $validatedPayload
                            ->only('nama', 'keterangan', 'gambar')
                            ->put('peta_type', $area::class)
                            ->put('peta_id', $area->getKey())
                            ->put('path', 'peta/area')
                    );
            }
        ));
    }
}
