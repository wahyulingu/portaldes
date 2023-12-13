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
class MetaUpdateAction extends Action implements RuledActionContract
{
    protected Meta $meta;

    public function __construct(protected MetaRepository $metaRepository)
    {
    }

    public function prepare(Meta $meta): self
    {
        return tap($this, fn (self $action) => $action->meta = $meta);
    }

    public function rules(Collection $payload): array
    {
        return [
            'name' => ['sometimes', 'string'],
            'value' => ['sometimes'],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return $this->metaRepository->update($this->meta->getKey(), $validatedPayload);
    }
}
