<?php

/**
 * Summary of namespace App\Actions\File.
 */

namespace App\Actions\File;

use App\Abstractions\Action\Action;
use App\Contracts\Action\RuledActionContract;
use App\Contracts\Model\HasFile;
use App\Models\File;
use App\Repositories\FileRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Summary of Upload.
 */
class FileUploadAction extends Action implements RuledActionContract
{
    protected Model&HasFile $fileable;

    public function __construct(protected FileRepository $fileRepository)
    {
    }

    public function prepare(HasFile&Model $fileable)
    {
        $this->fileable = $fileable;

        return $this;
    }

    /**
     * Summary of rules.
     */
    public function rules(array $payload): array
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
    protected function handler(array $validatedPayload = [], array $payload = []): File
    {
        return $this->fileRepository->create($this->fileable, $validatedPayload);
    }
}
