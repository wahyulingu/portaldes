<?php

namespace App\Models\Sid\Kelompok;

use App\Traits\Model\HasRepository;
use App\Traits\Model\Relations\Sid\BelongsToSidPendudukAsKetua;
use App\Traits\Model\Relations\Sid\MorphToManySidBantuan;
use App\Traits\Model\Relations\Sid\MorphToManySidPenduduk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SidKelompok extends Model
{
    use HasFactory;
    use HasRepository;
    use MorphToManySidPenduduk;
    use MorphToManySidBantuan;
    use BelongsToSidPendudukAsKetua;

    protected $guarded = ['id'];
    protected $table = 'sid_kelompok';

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(SidKelompokKategori::class, 'kategori_id');
    }
}
