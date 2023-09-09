<?php

namespace App\Models\Sid;

use App\Enumerations;
use App\Models\Sid\Wilayah\SidWilayahRukunTetangga;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SidPenduduk extends Model
{
    use HasFactory;

    protected $casts = [
        'kelamin' => Enumerations\Medis\JenisKelamin::class,
        'hubunganKeluarga' => Enumerations\Penduduk\HubunganKeluarga::class,
        'pekerjaan' => Enumerations\Penduduk\Pekerjaan::class,
        'pendidikanKk' => Enumerations\Pendidikan\Pendidikan::class,
        'pendidikanTempuh' => Enumerations\Pendidikan\Tempuh::class,
        'kewarganegaraan' => Enumerations\Penduduk\WargaNegara::class,
        'ktp' => Enumerations\Penduduk\Status\Ktp::class,
        'statusKtp' => Enumerations\Penduduk\Status\Ktp::class,
        'statusPenduduk' => Enumerations\Penduduk\Status::class,
        'statusDasar' => Enumerations\Penduduk\Status\Dasar::class,
        'agama' => Enumerations\Penduduk\Agama::class,
        'tempatDilahirkan' => Enumerations\Medis\Kelahiran\Tempat::class,
        'jenisKelahiran' => Enumerations\Medis\Kelahiran\Jenis::class,
        'penolongKelahiran' => Enumerations\Medis\Kelahiran\Penolong::class,
        'statusKawin' => Enumerations\Penduduk\Status\Perkawinan::class,
        'darah' => Enumerations\Medis\GolonganDarah::class,
        'cacat' => Enumerations\Medis\Cacat::class,
        'sakit' => Enumerations\Medis\Penyakit::class,
        'hamil' => Enumerations\Medis\Kehamilan::class,
        'kb' => Enumerations\Medis\Kontrasepsi::class,
    ];

    protected $guarded = ['id'];
    protected $table = 'sid_penduduk';

    public function keluarga()
    {
        return $this->belongsTo(SidKeluarga::class, 'no_kk', 'no_kk');
    }

    public function rukunTetangga()
    {
        return $this->belongsTo(SidWilayahRukunTetangga::class);
    }
}
