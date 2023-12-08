<?php

namespace App\Models\Sid\Penduduk\Kelompok;

use App\Traits\Model\Relations\Sid\BelongsToSidPendudukAsKetua;
use App\Traits\Model\Relations\Sid\MorphToManySidPenduduk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SidPendudukKelompok extends Model
{
    use HasFactory;
    use MorphToManySidPenduduk;
    use BelongsToSidPendudukAsKetua;

    protected $guarded = ['id'];
    protected $table = 'sid_penduduk_kelompok';

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(SidPendudukKelompokKategori::class);
    }
}
