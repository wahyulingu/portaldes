<?php

namespace App\Repositories;

use App\Abstractions\Repository\Repository;
use App\Models\File;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FileRepository extends Repository
{
    /**
     * Returns the disk to be used.
     */
    public function disk(): string
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('app.file_disk', 'public');
    }

    /**
     * Returns the filesystem.
     *
     * @param string $fileDisk (optional)
     */
    public function filesystemAdapter(string $fileDisk = ''): FilesystemAdapter
    {
        return Storage::disk($fileDisk ?: $this->disk());
    }

    /**
     * Uploads a file and returns its path.
     */
    public function upload(UploadedFile $file, string $path): string
    {
        return $file->storePublicly($path, ['disk' => $this->disk()]);
    }

    /**
     * Creates a file and returns it.
     */
    public function create(array $attributes): ?File
    {
        if (@$attributes['file'] instanceof UploadedFile) {
            $attributes['path'] = $this->upload($attributes['file'], $attributes['path'] ?? 'files');
            $attributes['original_name'] = $attributes['file']->getClientOriginalName();

            return $this->store($attributes);
        }
    }

    /**
     * Updates a file and returns a boolean indicating success.
     */
    public function update($key, array $attributes): bool
    {
        return DB::transaction(function () use ($attributes, $key) {
            if (@$attributes['file'] instanceof UploadedFile) {
                $attributes['path'] = $this->upload($attributes['file'], $attributes['path'] ?? 'files');

                $oldFile = $this->find($key, 'path')->path;
            }

            return tap(parent::update($key, $attributes), function (bool $success) use ($oldFile) {
                if ($oldFile && $success) {
                    $this->filesystemAdapter()->delete($oldFile);
                }
            });
        });
    }

    public function fake($fileDisk = '')
    {
        return Storage::fake($fileDisk ?: $this->disk());
    }

    public function uploadFake()
    {
        return UploadedFile::fake();
    }
}
