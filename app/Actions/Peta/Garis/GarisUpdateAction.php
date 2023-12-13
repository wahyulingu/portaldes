<?php

namespace App\Actions\Peta\Garis;

use App\Abstractions\Action\Action;
use App\Actions\Peta\Gambar\GambarStoreAction;
use App\Actions\Peta\Gambar\GambarUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Peta\PetaGaris;
use App\Models\Peta\PetaKategori;
use App\Repositories\Peta\PetaGarisRepository;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class GarisUpdateAction extends Action implements RuledActionContract
{
    protected PetaGaris $garis;

    public function __construct(
        protected readonly PetaGarisRepository $petaGarisRepository,
        protected readonly GambarStoreAction $gambarStoreAction,
        protected readonly GambarUpdateAction $gambarUpdateAction
    ) {
    }

    public function prepare(PetaGaris $garis)
    {
        return tap($this, fn (self $action) => $action->garis = $garis);
    }

    public function rules(Collection $payload): array
    {
        return [
            'kategori_id' => ['sometimes', 'integer', Rule::exists(PetaKategori::class, 'id')],
            'nama' => ['sometimes', 'string', 'max:255'],
            'keterangan' => ['sometimes', 'string', 'max:255'],
            'path' => ['sometimes', 'array'],
            'gambar' => ['sometimes', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        if ($validatedPayload->has('gambar')) {
            if ($this->garis->gambar()->exists()) {
                $this

                    ->gambarUpdateAction
                    ->prepare($this->garis->gambar)
                    ->execute($validatedPayload->only('gambar'));
            } else {
                $this->gambarStoreAction->skipAllRules()->execute(
                    $validatedPayload
                        ->only('nama', 'keterangan', 'gambar')
                        ->put('peta_type', $this->garis::class)
                        ->put('peta_id', $this->garis->getKey())
                );
            }

            $validatedPayload->forget('gambar');
        }

        if ($validatedPayload->isEmpty()) {
            return true;
        }

        return $this->petaGarisRepository->update($this->garis->getKey(), $validatedPayload);
    }
}
