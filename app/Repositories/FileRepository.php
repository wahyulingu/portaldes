<?php

namespace App\Repositories;

use App\Abstractions\Repository\Repository;
use App\Contracts\Model\HasFile;
use App\Models\File;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
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
    public function create(HasFile $fileable, array $attributes): File
    {
        $file = $attributes['file'] ?? null;

        if ($file instanceof UploadedFile) {
            $attributes['path'] = $this->upload($file, $attributes['path'] ?? 'files');
            $attributes['original_name'] = $file->getClientOriginalName();
        }

        return $fileable->file()->create($attributes);
    }

    /**
     * Updates a file and returns a boolean indicating success.
     */
    public function update($key, array $attributes): bool
    {
        $file = $attributes['file'] ?? null;

        if ($file instanceof UploadedFile) {
            $attributes['path'] = $this->upload($file, $attributes['path'] ?? 'files');

            $oldFile = $this->find($key, 'path')->path;
        }

        $success = parent::update($key, $attributes);

        if ($oldFile && $success) {
            $this->filesystemAdapter()->delete($oldFile);
        }

        return $success;
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
