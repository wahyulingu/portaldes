<?php

namespace App\Models\Sid;

use App\Enumerations\SasaranBantuan;
use App\Models\Sid\Kelompok\SidKelompok;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class SidBantuan extends Model
{
    use HasFactory;

    protected $casts = [
        'awal' => 'date:d-m-Y',
        'akhir' => 'date:d-m-Y',
        'sasaran' => SasaranBantuan::class,
    ];

    protected $fillable = ['awal', 'akhir', 'nama', 'keterangan', 'sasaran'];

    protected $table = 'sid_bantuan';

    public function penduduk(): MorphToMany
    {
        return $this->modelHasSidBantuan(SidPenduduk::class);
    }

    public function keluarga(): MorphToMany
    {
        return $this->modelHasSidBantuan(SidKeluarga::class);
    }

    public function kelompok(): MorphToMany
    {
        return $this->modelHasSidBantuan(SidKelompok::class);
    }

    public function penerima(): MorphToMany
    {
        if (!empty($this->sasaran)) {
            return $this->modelHasSidBantuan($this->sasaran->value);
        }

        return $this->penduduk();
    }

    protected function modelHasSidBantuan($model): MorphToMany
    {
        return $this->morphedByMany($model, 'sid_model_has_sid_bantuan', 'sid_model_has_sid_bantuan');
    }
}
