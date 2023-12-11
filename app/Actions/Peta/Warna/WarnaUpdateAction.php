<?php

namespace App\Actions\Peta\Warna;

use App\Abstractions\Action\Action;
use App\Actions\Peta\Gambar\GambarStoreAction;
use App\Actions\Peta\Gambar\GambarUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Moderation;
use App\Models\Peta\PetaCategory;
use App\Models\Peta\PetaWarna;
use App\Repositories\Peta\PetaWarnaRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

class WarnaUpdateAction extends Action implements RuledActionContract
{
    protected PetaWarna $warna;

    public function __construct(
        protected readonly PetaWarnaRepository $petaWarnaRepository,
        protected readonly GambarStoreAction $gambarStoreAction,
        protected readonly GambarUpdateAction $gambarUpdateAction
    ) {
    }

    public function prepare(PetaWarna $warna)
    {
        return tap($this, fn (self $action) => $action->warna = $warna);
    }

    public function rules(array $payload): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'body' => ['sometimes', 'string'],
            'description' => ['sometimes', 'string', 'max:255'],
            'category_id' => ['sometimes', Rule::exists(PetaCategory::class, 'id')],
            'warna' => ['sometimes', 'mimes:jpg,jpeg,png', 'max:1024'],
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

        return $this->petaWarnaRepository->update($this->warna->getKey(), $validatedPayload);
    }

    protected function updateGambar(UploadedFile $image)
    {
        if ($this->warna->gambar()->exists()) {
            return $this

                ->gambarUpdateAction
                ->prepare($this->warna->gambar)
                ->execute(compact('image'));
        }

        return $this

            ->gambarStoreAction
            ->prepare($this->warna)
            ->execute(compact('image'));
    }
}
