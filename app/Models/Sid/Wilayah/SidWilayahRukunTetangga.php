<?php

namespace App\Models\Sid\Wilayah;

use App\Models\Sid\SidKeluarga;
use App\Models\Sid\SidPenduduk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SidWilayahRukunTetangga extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'sid_wilayah_rukun_tetangga';

    public function rukunWarga(): BelongsTo
    {
        return $this->belongsTo(SidWilayahRukunWarga::class);
    }

    public function penduduk(): HasMany
    {
        return $this->hasMany(SidPenduduk::class);
    }

    public function keluarga(): HasMany
    {
        return $this->hasMany(SidKeluarga::class);
    }
}
