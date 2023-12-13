<?php

namespace App\Actions\Peta\Simbol;

use App\Abstractions\Action\Action;
use App\Actions\Peta\Gambar\GambarStoreAction;
use App\Actions\Peta\Gambar\GambarUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Models\Peta\PetaSimbol;
use App\Repositories\Peta\PetaSimbolRepository;
use Illuminate\Support\Collection;

class SimbolUpdateAction extends Action implements RuledActionContract
{
    protected PetaSimbol $simbol;

    public function __construct(
        protected readonly PetaSimbolRepository $petaSimbolRepository,
        protected readonly GambarStoreAction $gambarStoreAction,
        protected readonly GambarUpdateAction $gambarUpdateAction
    ) {
    }

    public function prepare(PetaSimbol $simbol)
    {
        return tap($this, fn (self $action) => $action->simbol = $simbol);
    }

    public function rules(Collection $payload): array
    {
        return [
            'nama' => ['sometimes', 'string', 'max:255'],
            'keterangan' => ['sometimes', 'string', 'max:255'],
            'gambar' => ['sometimes', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        if ($validatedPayload->has('gambar')) {
            if ($this->simbol->gambar()->exists()) {
                $this

                    ->gambarUpdateAction
                    ->prepare($this->simbol->gambar)
                    ->execute($validatedPayload->only('gambar'));
            } else {
                $this->gambarStoreAction->skipAllRules()->execute(
                    $validatedPayload
                        ->only('nama', 'keterangan', 'gambar')
                        ->put('peta_type', $this->simbol::class)
                        ->put('peta_id', $this->simbol->getKey())
                        ->put('path', 'peta/simbol')
                );
            }

            $validatedPayload->forget('gambar');
        }

        if ($validatedPayload->isEmpty()) {
            return true;
        }

        return $this->petaSimbolRepository->update($this->simbol->getKey(), $validatedPayload);
    }
}
