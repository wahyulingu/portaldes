<?php

namespace App\Models\Sid\Wilayah;

use App\Models\Sid\SidPenduduk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class SidWilayahRukunWarga extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'sid_wilayah_rukun_warga';

    public function lingkungan(): BelongsTo
    {
        return $this->belongsTo(SidWilayahLingkungan::class);
    }

    public function rukunTetangga(): HasMany
    {
        return $this->hasMany(SidWilayahRukunTetangga::class);
    }

    public function penduduk(): HasManyThrough
    {
        return $this->hasManyThrough(SidPenduduk::class, [SidWilayahRukunTetangga::class, SidWilayahRukunWarga::class]);
    }
}
