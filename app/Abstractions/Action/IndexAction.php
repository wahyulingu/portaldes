<?php

namespace App\Abstractions\Action;

use App\Abstractions\Repository\Repository;
use App\Contracts\Action\PaginatedActionContract;
use App\Contracts\Action\RuledActionContract;

abstract class IndexAction extends Action implements RuledActionContract
{
    public function __construct(readonly protected Repository $repository)
    {
    }

    public function rules(array $payload): array
    {
        return [
            'keyword' => 'nullable|string',
            'columns' => 'nullable|array',
            'limit' => 'nullable|numeric|min:1',
            'pageName' => 'nullable|string',
            'relations' => 'nullable|array',
            'relationsCount' => 'nullable|array',
        ];
    }

    abstract protected function filters(array $payload = []): array;

    protected function handler(array $validatedPayload = [], array $payload = [])
    {
        $this

            ->repository
            ->filter($this->filters($validatedPayload))
            ->latest();

        if (!empty($validatedPayload['relations'])) {
            $this->repository->with($validatedPayload['relations']);
        }

        if (!empty($validatedPayload['relationsCount'])) {
            $this->repository->withCount($validatedPayload['relationsCount']);
        }

        if ($this instanceof PaginatedActionContract) {
            return $this

                ->repository
                ->paginate(
                    limit: @$validatedPayload['limit'] ?: 1,
                    columns: @$validatedPayload['columns'] ?: ['*'],
                    pageName: @$validatedPayload['pageName'] ?: 'page'
                );
        }

        return $this

            ->repository
            ->get(@$validatedPayload['columns'] ?: ['*']);
    }
}
