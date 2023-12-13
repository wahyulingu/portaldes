<?php

namespace App\Actions\File;

use App\Abstractions\Action\Action;
use App\Models\File;
use App\Repositories\FileRepository;
use Illuminate\Support\Collection;

class FileDeleteAction extends Action
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

    protected function handler(Collection $validatedPayload, Collection $payload): bool
    {
        return tap(
            $this->fileRepository->delete($this->file->getKey()),
            fn () => $this->deleteFileFromStorage()
        );
    }

    protected function deleteFileFromStorage()
    {
        if (!empty($this->file->path)) {
            $this->fileRepository->fileSystemAdapter()->delete($this->file->path);
        }
    }
}
