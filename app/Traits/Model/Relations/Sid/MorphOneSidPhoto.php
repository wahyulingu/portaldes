<?php

namespace App\Traits\Model\Relations\Sid;

use App\Models\Sid\SidPhoto;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait MorphOneSidPhoto
{
    public function photo(): MorphOne
    {
        return $this->morphOne(SidPhoto::class, 'sid');
    }
}
