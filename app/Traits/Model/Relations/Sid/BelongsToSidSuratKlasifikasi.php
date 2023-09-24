<?php

namespace App\Traits\Model\Relations\Sid;

use App\Models\Sid\Surat\SidSuratKlasifikasi;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToSidSuratKlasifikasi
{
    public function surat(): BelongsTo
    {
        return $this->belongsTo(SidSuratKlasifikasi::class);
    }
}
