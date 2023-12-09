<?php

namespace App\Traits\Model\Relations\Sid;

use App\Models\Sid\SidPenduduk;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait MorphToManySidPenduduk
{
    /**
     * A model may have multiple categories.
     */
    public function penduduk(): MorphToMany
    {
        return $this->morphToMany(SidPenduduk::class, 'model_has_sid_penduduk', 'model_has_sid_penduduk');
    }
}
