<?php

namespace App\Actions\Peta\Garis;

use App\Abstractions\Action\Action;
use App\Actions\Peta\Gambar\GambarStoreAction;
use App\Actions\Peta\Gambar\GambarUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Peta\PetaGaris;
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
            'nama' => ['sometimes', 'string', 'max:255'],
            'keterangan' => ['sometimes', 'string', 'max:255'],
            'lat' => ['sometimes', 'string'],
            'lng' => ['sometimes', 'string'],

            'kategori_id' => [
                'sometimes',
                Rule::exists(PetaKategori::class, 'id'),
            ],

            'gambar' => ['sometimes', 'mimes:jpg,jpeg,png', 'max:2048'],
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
                $gambar = $this->gambarStoreAction->skipAllRules()->execute([
                    'nama' => $validatedPayload->get('nama', $this->garis->nama),
                    'keterangan' => $validatedPayload->get('keterangan', $this->garis->keterangan),
                    'gambar' => $validatedPayload->get('gambar'),
                ]);

                $this->garis->gambar()->save($gambar);
            }

            $validatedPayload->forget('gambar');
        }

        if ($validatedPayload->isEmpty()) {
            return true;
        }

        return $this->petaGarisRepository->update($this->garis->getKey(), $validatedPayload);
    }
}
