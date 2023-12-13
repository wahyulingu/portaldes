<?php

namespace App\Actions\Peta\Area;

use App\Abstractions\Action\Action;
use App\Actions\Peta\Gambar\GambarStoreAction;
use App\Actions\Peta\Gambar\GambarUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Peta\PetaArea;
use App\Repositories\Peta\PetaAreaRepository;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class AreaUpdateAction extends Action implements RuledActionContract
{
    protected PetaArea $area;

    public function __construct(
        protected readonly PetaAreaRepository $petaAreaRepository,
        protected readonly GambarStoreAction $gambarStoreAction,
        protected readonly GambarUpdateAction $gambarUpdateAction
    ) {
    }

    public function prepare(PetaArea $area)
    {
        return tap($this, fn (self $action) => $action->area = $area);
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
            if ($this->area->gambar()->exists()) {
                $this

                    ->gambarUpdateAction
                    ->prepare($this->area->gambar)
                    ->execute($validatedPayload->only('gambar'));
            } else {
                $gambar = $this->gambarStoreAction->skipAllRules()->execute([
                    'nama' => $validatedPayload->get('nama', $this->area->nama),
                    'keterangan' => $validatedPayload->get('keterangan', $this->area->keterangan),
                    'gambar' => $validatedPayload->get('gambar'),
                ]);

                $this->area->gambar()->save($gambar);
            }

            $validatedPayload->forget('gambar');
        }

        if ($validatedPayload->isEmpty()) {
            return true;
        }

        return $this->petaAreaRepository->update($this->area->getKey(), $validatedPayload);
    }
}
