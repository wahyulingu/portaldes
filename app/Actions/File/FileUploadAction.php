<?php

/**
 * Summary of namespace App\Actions\File.
 */

namespace App\Actions\File;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Models\File;
use App\Repositories\FileRepository;
use Illuminate\Support\Collection;

/**
 * Summary of Upload.
 */
class FileUploadAction extends Action implements RuledActionContract
{
    public function __construct(protected FileRepository $fileRepository)
    {
    }

    /**
     * Summary of rules.
     */
    public function rules(Collection $payload): array
    {
        return [
            'file' => ['required', 'file'],
            'path' => ['sometimes', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ];
    }

    /**
     * Summary of handler.
     */
    protected function handler(Collection $validatedPayload, Collection $payload): File
    {
        return $this->fileRepository->create($validatedPayload);
    }
}
