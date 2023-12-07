<?php

namespace App\Models;

use App\Repositories\FileRepository;
use App\Traits\Model\HasRepository;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends Model
{
    use HasFactory;
    use HasRepository;

    protected $fillable = ['name', 'original_name', 'description', 'path', 'fileable_id', 'fileable_type'];

    protected $appends = ['url'];

    protected function url(): Attribute
    {
        /**
         * @var FileRepository
         */
        $fileRepository = app(FileRepository::class);

        return Attribute::make(fn () => $this->path
                ? $fileRepository->filesystemAdapter()->url($this->path)
                : null
        );
    }

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
}
