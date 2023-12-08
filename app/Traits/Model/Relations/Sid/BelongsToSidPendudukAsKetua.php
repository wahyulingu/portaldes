<?php

namespace App\Traits\Model\Relations\Sid;

use App\Models\Sid\Penduduk\SidPenduduk;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToSidPendudukAsKetua
{
    public function ketua(): BelongsTo
    {
        return $this->belongsTo(SidPenduduk::class);
    }
}
