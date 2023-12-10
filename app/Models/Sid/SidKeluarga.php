<?php

namespace App\Models\Sid;

use App\Enumerations\Penduduk\HubunganKeluarga;
use App\Enumerations\Penduduk\Status\Sosial;
use App\Models\Sid\Wilayah\SidWilayahRukunTetangga;
use App\Traits\Model\Relations\Sid\MorphToManySidBantuan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SidKeluarga extends Model
{
    use HasFactory;
    use MorphToManySidBantuan;

    protected $casts = ['sosial' => Sosial::class];

    protected $guarded = ['id'];

    protected $table = 'sid_keluarga';

    public function anggota(): HasMany
    {
        return $this->hasMany(SidPenduduk::class, 'nomor_kartu_keluarga', 'nomor_kartu_keluarga');
    }

    public function rukunTetangga()
    {
        return $this->belongsTo(SidWilayahRukunTetangga::class);
    }

    public function kepala(): HasOne
    {
        return $this

            ->hasOne(SidPenduduk::class, 'nomor_kartu_keluarga', 'nomor_kartu_keluarga')
            ->whereHubunganKeluarga(HubunganKeluarga::kepala);
    }
}
