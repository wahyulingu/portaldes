<?php

namespace App\Actions\File;

use App\Abstractions\Action\Action;
use App\Models\File;
use App\Repositories\FileRepository;
use App\Traits\Action\SetCollection;
use Illuminate\Support\Collection;

class FileBulkDelete extends Action
{
    use SetCollection;

    public function __construct(protected FileRepository $fileRepository)
    {
    }

    protected function handler(Collection $validatedPayload, Collection $payload)
    {
        return tap(
            File::whereIn('id', $this->collection->map(
                fn (File $file) => $file->getKey()
            ))->delete(),

            fn () => $this->fileRepository->filesystemAdapter()->delete(
                $this->collection->map(
                    fn (File $file) => $file->path
                )->reject(null)->values()
            )
        );
    }
}
