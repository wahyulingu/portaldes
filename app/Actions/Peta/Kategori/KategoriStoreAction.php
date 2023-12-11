<?php

namespace App\Actions\Peta\Kategori;

use App\Abstractions\Action\Action;
use App\Actions\Peta\Gambar\GambarStoreAction;
use App\Contracts\Action\RuledActionContract;
use App\Enumerations\Moderation;
use App\Models\Peta\PetaCategory;
use App\Models\Peta\PetaKategori;
use App\Models\User;
use App\Repositories\Peta\PetaKategoriRepository;
use Illuminate\Validation\Rule;

/**
 * @extends Action<PetaKategori>
 */
class KategoriStoreAction extends Action implements RuledActionContract
{
    protected User $user;

    public function __construct(
        protected PetaKategoriRepository $petaKategoriRepository,
    ) {
    }

    public function rules(Collection $payload): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'description' => ['required', 'string', 'max:255'],

            'user_id' => [
                'required',
                Rule::exists(User::class, 'id'),
            ],

            'category_id' => [
                'sometimes',
                Rule::exists(PetaCategory::class, 'id'),
            ],

            'status' => [
                'sometimes',
                Rule::in(Moderation::names()),
            ],

            'gambar' => ['sometimes', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return tap(
            $this->petaKategoriRepository->store($validatedPayload),
            function (PetaKategori $peta) {
                // if (isset($validatedPayload['gambar'])) {
                //     $this

                //         ->gambarStoreAction
                //         ->prepare($peta)
                //         ->skipAllRules()
                //         ->execute($validatedPayload);
                // }
            }
        );
    }
}
