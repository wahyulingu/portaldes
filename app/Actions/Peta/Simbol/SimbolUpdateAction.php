<?php

namespace App\Actions\Peta\Simbol;

use App\Abstractions\Action\Action;
use App\Actions\Peta\Gambar\GambarStoreAction;
use App\Actions\Peta\Gambar\GambarUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Moderation;
use App\Models\Peta\PetaCategory;
use App\Models\Peta\PetaSimbol;
use App\Repositories\Peta\PetaSimbolRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

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

    public function rules(array $payload): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'body' => ['sometimes', 'string'],
            'description' => ['sometimes', 'string', 'max:255'],
            'category_id' => ['sometimes', Rule::exists(PetaCategory::class, 'id')],
            'simbol' => ['sometimes', 'mimes:jpg,jpeg,png', 'max:1024'],
            'gambar' => ['sometimes', 'mimes:jpg,jpeg,png', 'max:1024'],
            'status' => ['sometimes', Rule::in(Moderation::names())],
        ];
    }

    protected function handler(array $validatedPayload = [], array $payload = []): bool
    {
        if (isset($validatedPayload['gambar'])) {
            $this->updateGambar($validatedPayload['gambar']);

            unset($validatedPayload['gambar']);
        }

        if (empty($validatedPayload)) {
            return true;
        }

        return $this->petaSimbolRepository->update($this->simbol->getKey(), $validatedPayload);
    }

    protected function updateGambar(UploadedFile $image)
    {
        if ($this->simbol->gambar()->exists()) {
            return $this

                ->gambarUpdateAction
                ->prepare($this->simbol->gambar)
                ->execute(compact('image'));
        }

        return $this

            ->gambarStoreAction
            ->prepare($this->simbol)
            ->execute(compact('image'));
    }
}
