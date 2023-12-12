<?php

namespace App\Actions\Peta\Titik;

use App\Abstractions\Action\Action;
use App\Actions\Peta\Gambar\GambarStoreAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Peta\PetaKategori;
use App\Models\Peta\PetaTitik;
use App\Models\User;
use App\Repositories\Peta\PetaTitikRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * @extends Action<PetaTitik>
 */
class TitikStoreAction extends Action implements RuledActionContract
{
    protected User $user;

    public function __construct(
        protected PetaTitikRepository $petaTitikRepository,
        protected GambarStoreAction $gambarStoreAction
    ) {
    }

    public function rules(Collection $payload): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'keterangan' => ['required', 'string', 'max:255'],
            'lat' => ['required', 'string'],
            'lng' => ['required', 'string'],

            'kategori_id' => [
                'required',
                Rule::exists(PetaKategori::class, 'id'),
            ],

            'gambar' => ['sometimes', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        [
            'nama' => ['required', 'string', 'max:255'],
            'keterangan' => ['required', 'string', 'max:255'],
            'gambar' => ['required', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];

        return DB::transaction(fn () => tap(
            $this->petaTitikRepository->store($validatedPayload),
            function (PetaTitik $titik) use ($validatedPayload) {
                if ($validatedPayload->has('gambar')) {
                    $gambar = $this

                        ->gambarStoreAction
                        ->skipAllRules()
                        ->execute(
                            $validatedPayload->only(
                                [
                                    'nama',
                                    'keterangan',
                                    'gambar',
                                ]
                            )
                        );

                    $titik->gambar()->save($gambar);
                }
            }
        ));
    }
}
