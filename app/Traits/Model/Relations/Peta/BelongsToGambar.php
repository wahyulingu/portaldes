<?php

namespace App\Traits\Model\Relations\Peta;

use App\Models\Peta\PetaGambar;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToGambar
{
    /**
     * A model may have multiple categories.
     */
    public function gambar(): BelongsTo
    {
        return $this->belongsTo(PetaGambar::class);
    }
}
