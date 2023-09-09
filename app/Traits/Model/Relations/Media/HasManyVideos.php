<?php

namespace App\Traits\Model\Relations\Media;

use App\Models\Media\MediaVideo;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyVideos
{
    /**
     * A model may have multiple files.
     */
    public function videos(): HasMany
    {
        return $this->hasMany(MediaVideo::class);
    }
}
