<?php

namespace App\Traits\Model\Relations\Sid;

use App\Models\Sid\SidPhoto;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait MorphOnePhoto
{
    /**
     * A model may have multiple files.
     */
    public function photo(): MorphOne
    {
        return $this->morphOne(SidPhoto::class, 'sid');
    }
}
