<?php

namespace App\Traits\Model\Relations\Media;

use App\Models\Media\MediaPicture;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyPictures
{
    /**
     * A model may have multiple files.
     */
    public function pictures(): HasMany
    {
        return $this->hasMany(MediaPicture::class);
    }
}
