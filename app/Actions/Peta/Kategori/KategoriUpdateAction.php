<?php

namespace App\Actions\Peta\Kategori;

use App\Abstractions\Action\Action;
use App\Actions\Peta\Gambar\GambarStoreAction;
use App\Actions\Peta\Gambar\GambarUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Peta\PetaKategori;
use App\Repositories\Peta\PetaKategoriRepository;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class KategoriUpdateAction extends Action implements RuledActionContract
{
    protected PetaKategori $kategori;

    public function __construct(
        protected readonly PetaKategoriRepository $petaKategoriRepository,
        protected readonly GambarStoreAction $gambarStoreAction,
        protected readonly GambarUpdateAction $gambarUpdateAction
    ) {
    }

    public function prepare(PetaKategori $kategori)
    {
        return tap($this, fn (self $action) => $action->kategori = $kategori);
    }

    public function rules(Collection $payload): array
    {
        return [
            'nama' => ['sometimes', 'string', 'max:255'],
            'keterangan' => ['sometimes', 'string', 'max:255'],
            'tipe' => ['sometimes', 'string', Rule::enum(TipePeta::class)],

            'warna_id' => [
                'sometimes',
                Rule::exists(PetaWarna::class, 'id'),
            ],

            'simbol_id' => [
                'sometimes',
                Rule::exists(PetaKategori::class, 'id'),
            ],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        return $this->petaKategoriRepository->update($this->kategori->getKey(), $validatedPayload);
    }
}
