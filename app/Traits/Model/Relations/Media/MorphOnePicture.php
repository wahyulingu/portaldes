<?php

namespace App\Traits\Model\Relations\Media;

use App\Models\Media\MediaPicture;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait MorphOnePicture
{
    public function picture(): MorphOne
    {
        return $this->morphOne(MediaPicture::class, 'pictureable');
    }
}
