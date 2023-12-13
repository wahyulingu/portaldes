<?php

namespace App\Actions\Peta\Titik;

use App\Abstractions\Action\Action;
use App\Actions\Peta\Gambar\GambarStoreAction;
use App\Actions\Peta\Gambar\GambarUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Peta\PetaTitik;
use App\Repositories\Peta\PetaTitikRepository;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class TitikUpdateAction extends Action implements RuledActionContract
{
    protected PetaTitik $titik;

    public function __construct(
        protected readonly PetaTitikRepository $petaTitikRepository,
        protected readonly GambarStoreAction $gambarStoreAction,
        protected readonly GambarUpdateAction $gambarUpdateAction
    ) {
    }

    public function prepare(PetaTitik $titik)
    {
        return tap($this, fn (self $action) => $action->titik = $titik);
    }

    public function rules(Collection $payload): array
    {
        return [
            'kategori_id' => ['sometimes', 'integer', Rule::exists(PetaKategori::class, 'id')],
            'nama' => ['sometimes', 'string', 'max:255'],
            'keterangan' => ['sometimes', 'string', 'max:255'],
            'lat' => ['sometimes', 'string'],
            'lng' => ['sometimes', 'string'],
            'gambar' => ['sometimes', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        if ($validatedPayload->has('gambar')) {
            if ($this->titik->gambar()->exists()) {
                $this

                    ->gambarUpdateAction
                    ->prepare($this->titik->gambar)
                    ->execute($validatedPayload->only('gambar'));
            } else {
                $this->gambarStoreAction->skipAllRules()->execute(
                    $validatedPayload
                        ->only('nama', 'keterangan', 'gambar')
                        ->put('peta_type', $this->titik::class)
                        ->put('peta_id', $this->titik->getKey())
                );
            }

            $validatedPayload->forget('gambar');
        }

        if ($validatedPayload->isEmpty()) {
            return true;
        }

        return $this->petaTitikRepository->update($this->titik->getKey(), $validatedPayload);
    }
}
