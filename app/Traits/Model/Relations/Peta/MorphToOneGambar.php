<?php

namespace App\Traits\Model\Relations\Peta;

use App\Models\Peta\PetaGambar;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait MorphToOneGambar
{
    /**
     * A peta may have multiple files.
     */
    public function gambar(): MorphOne
    {
        return $this->morphOne(PetaGambar::class, 'peta');
    }
}
