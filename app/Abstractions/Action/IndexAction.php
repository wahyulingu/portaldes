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
        $rules = [
            'keyword' => 'nullable|string',
            'columns' => 'nullable|array',
            'limit' => 'nullable|numeric|min:1',
            'relations' => 'nullable|array',
            'relationsCount' => 'nullable|array',
        ];

        if ($this instanceof PaginatedActionContract) {
            return [...$rules, 'pageName' => 'nullable|string'];
        }

        return [...$rules, 'offset' => 'nullable|numeric'];
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

        if (!empty($validatedPayload['offset'])) {
            $this->repository->offset($validatedPayload['offset']);
        }

        if (!empty($validatedPayload['limit'])) {
            $this->repository->limit($validatedPayload['limit']);
        }

        return $this

            ->repository
            ->get(@$validatedPayload['columns'] ?: ['*']);
    }
}
