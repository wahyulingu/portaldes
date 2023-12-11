<?php

namespace App\Actions\Peta\Gambar;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Moderation;
use App\Models\Peta\PetaCategory;
use App\Models\Peta\PetaGambar;
use App\Repositories\Peta\PetaGambarRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

class GambarUpdateAction extends Action implements RuledActionContract
{
    protected PetaGambar $gambar;

    public function __construct(
        protected readonly PetaGambarRepository $petaGambarRepository,
        protected readonly GambarStoreAction $gambarStoreAction,
        protected readonly GambarUpdateAction $gambarUpdateAction
    ) {
    }

    public function prepare(PetaGambar $gambar)
    {
        return tap($this, fn (self $action) => $action->gambar = $gambar);
    }

    public function rules(array $payload): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'body' => ['sometimes', 'string'],
            'description' => ['sometimes', 'string', 'max:255'],
            'category_id' => ['sometimes', Rule::exists(PetaCategory::class, 'id')],
            'gambar' => ['sometimes', 'mimes:jpg,jpeg,png', 'max:1024'],
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

        return $this->petaGambarRepository->update($this->gambar->getKey(), $validatedPayload);
    }

    protected function updateGambar(UploadedFile $image)
    {
        if ($this->gambar->gambar()->exists()) {
            return $this

                ->gambarUpdateAction
                ->prepare($this->gambar->gambar)
                ->execute(compact('image'));
        }

        return $this

            ->gambarStoreAction
            // ->prepare($this->gambar)
            ->execute(compact('image'));
    }
}
