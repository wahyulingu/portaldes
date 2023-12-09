<?php

namespace App\Models\Sid\Kelompok;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SidKelompokKategori extends Model
{
    use HasFactory;

    protected $table = 'sid_kelompok_kategori';

    protected $fillable = ['nama', 'keterangan'];

    public function kelompok(): HasMany
    {
        return $this->hasMany(SidKelompok::class, 'kategori_id');
    }
}
