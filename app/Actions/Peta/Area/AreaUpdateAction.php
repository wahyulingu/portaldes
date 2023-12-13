<?php

namespace App\Actions\Peta\Area;

use App\Abstractions\Action\Action;
use App\Actions\Peta\Gambar\GambarStoreAction;
use App\Actions\Peta\Gambar\GambarUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Peta\PetaArea;
use App\Models\Peta\PetaKategori;
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
            if ($this->area->gambar()->exists()) {
                $this

                    ->gambarUpdateAction
                    ->prepare($this->area->gambar)
                    ->execute($validatedPayload->only('gambar'));
            } else {
                $this->gambarStoreAction->skipAllRules()->execute(
                    $validatedPayload
                        ->only('nama', 'keterangan', 'gambar')
                        ->put('peta_type', $this->area::class)
                        ->put('peta_id', $this->area->getKey())
                );
            }

            $validatedPayload->forget('gambar');
        }

        if ($validatedPayload->isEmpty()) {
            return true;
        }

        return $this->petaAreaRepository->update($this->area->getKey(), $validatedPayload);
    }
}
