<?php

namespace App\Actions\Peta\Kategori;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\TipePeta;
use App\Models\Peta\PetaKategori;
use App\Models\Peta\PetaSimbol;
use App\Models\Peta\PetaWarna;
use App\Models\User;
use App\Repositories\Peta\PetaKategoriRepository;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

/**
 * @extends Action<PetaKategori>
 */
class KategoriStoreAction extends Action implements RuledActionContract
{
    protected User $user;

    public function __construct(
        protected PetaKategoriRepository $petaKategoriRepository,
    ) {
    }

    public function rules(Collection $payload): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'keterangan' => ['required', 'string', 'max:255'],
            'tipe' => ['required', 'string', Rule::enum(TipePeta::class)],

            'warna_id' => [
                'required',
                Rule::exists(PetaWarna::class, 'id'),
            ],

            'simbol_id' => [
                'required',
                Rule::exists(PetaSimbol::class, 'id'),
            ],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return $this->petaKategoriRepository->store($validatedPayload);
    }
}
