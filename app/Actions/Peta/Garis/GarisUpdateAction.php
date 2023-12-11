<?php

namespace App\Actions\Peta\Garis;

use App\Abstractions\Action\Action;
use App\Actions\Peta\Gambar\GambarStoreAction;
use App\Actions\Peta\Gambar\GambarUpdateAction;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Moderation;
use App\Models\Peta\PetaCategory;
use App\Models\Peta\PetaGaris;
use App\Repositories\Peta\PetaGarisRepository;
use Illuminate\Http\UploadedFile;
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
            'title' => ['sometimes', 'string', 'max:255'],
            'body' => ['sometimes', 'string'],
            'description' => ['sometimes', 'string', 'max:255'],
            'category_id' => ['sometimes', Rule::exists(PetaCategory::class, 'id')],
            'garis' => ['sometimes', 'mimes:jpg,jpeg,png', 'max:1024'],
            'gambar' => ['sometimes', 'mimes:jpg,jpeg,png', 'max:1024'],
            'status' => ['sometimes', Rule::in(Moderation::names())],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        if (isset($validatedPayload['gambar'])) {
            $this->updateGambar($validatedPayload['gambar']);

            unset($validatedPayload['gambar']);
        }

        if (empty($validatedPayload)) {
            return true;
        }

        return $this->petaGarisRepository->update($this->garis->getKey(), $validatedPayload);
    }

    protected function updateGambar(UploadedFile $image)
    {
        if ($this->garis->gambar()->exists()) {
            return $this

                ->gambarUpdateAction
                ->prepare($this->garis->gambar)
                ->execute(compact('image'));
        }

        return $this

            ->gambarStoreAction
            ->prepare($this->garis)
            ->execute(compact('image'));
    }
}
