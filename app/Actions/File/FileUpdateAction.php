<?php

namespace App\Actions\File;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\File;
use App\Repositories\FileRepository;
use Illuminate\Support\Collection;

class FileUpdateAction extends Action implements RuledActionContract
{
    protected File $file;

    public function __construct(protected FileRepository $fileRepository)
    {
    }

    public function prepare(File $file)
    {
        $this->file = $file;

        return $this;
    }

    public function rules(Collection $payload): array
    {
        return [
            'file' => ['sometimes', 'file'],
            'path' => ['sometimes', 'string', 'max:255'],
            'name' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string', 'max:255'],
        ];
    }

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        return $this->fileRepository->update($this->file->getKey(), $validatedPayload);
    }
}
