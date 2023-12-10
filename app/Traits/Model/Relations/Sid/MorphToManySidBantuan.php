<?php

namespace App\Traits\Model\Relations\Sid;

use App\Models\Sid\SidBantuan;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait MorphToManySidBantuan
{
    /**
     * A model may have multiple categories.
     */
    public function bantuan(): MorphToMany
    {
        return $this->morphToMany(SidBantuan::class, 'sid_model_has_sid_bantuan', 'sid_model_has_sid_bantuan');
    }
}
