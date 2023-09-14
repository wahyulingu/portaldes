<?php

namespace App\Models\Sid;

use App\Enumerations\Penduduk\HubunganKeluarga;
use App\Enumerations\Penduduk\Status\Sosial;
use App\Models\Sid\Wilayah\SidWilayahRukunTetangga;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SidKeluarga extends Model
{
    use HasFactory;

    protected $casts = ['sosial' => Sosial::class];

    protected $guarded = ['id'];

    protected $table = 'sid_keluarga';

    public function anggota(): HasMany
    {
        return $this->hasMany(SidPenduduk::class, 'no_kk', 'no_kk');
    }

    public function rukunTetangga()
    {
        return $this->belongsTo(SidWilayahRukunTetangga::class);
    }

    public function kepala(): HasOne
    {
        return $this

            ->hasOne(SidPenduduk::class, 'no_kk', 'no_kk')
            ->whereHubunganKeluarga(HubunganKeluarga::kepala);
    }
}
