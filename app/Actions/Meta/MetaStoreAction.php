<?php

namespace App\Actions\Meta;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\Meta;
use App\Repositories\MetaRepository;
use Illuminate\Support\Collection;

/**
 * @extends Action<Meta>
 */
class MetaStoreAction extends Action implements RuledActionContract
{
    public function __construct(readonly protected MetaRepository $metaRepository)
    {
    }

    public function rules(Collection $payload): array
    {
        return [
            'name' => ['required', 'string'],
            'value' => ['required'],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return $this->metaRepository->store($validatedPayload);
    }
}
