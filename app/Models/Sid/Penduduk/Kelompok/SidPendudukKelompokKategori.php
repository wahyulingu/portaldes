<?php

namespace App\Models\Sid\Penduduk\Kelompok;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SidPendudukKelompokKategori extends Model
{
    use HasFactory;

    protected $table = 'sid_penduduk_kelompok_kategori';

    protected $fillable = ['nama', 'keterangan'];

    public function kelompok(): HasMany
    {
        return $this->hasMany(SidPendudukKelompok::class, 'kategori_id');
    }
}
