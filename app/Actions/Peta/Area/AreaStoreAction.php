<?php

namespace App\Actions\Peta\Area;

use App\Abstractions\Action\Action;
use App\Actions\Peta\Gambar\GambarStoreAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Peta\PetaArea;
use App\Models\Peta\PetaKategori;
use App\Models\User;
use App\Repositories\Peta\PetaAreaRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
            'kategori_id' => ['required', 'integer', Rule::exists(PetaKategori::class, 'id')],
            'nama' => ['required', 'string', 'max:255'],
            'keterangan' => ['required', 'string', 'max:255'],
            'path' => ['required', 'array'],
            'gambar' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
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
                    );
            }
        ));
    }
}
