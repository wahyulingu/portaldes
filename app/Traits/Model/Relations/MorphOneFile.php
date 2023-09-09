<?php

namespace App\Traits\Model\Relations;

use App\Models\File;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait MorphOneFile
{
    /**
     * A model may have multiple files.
     */
    public function file(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable');
    }
}
