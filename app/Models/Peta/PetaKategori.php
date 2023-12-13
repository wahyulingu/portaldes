<?php

namespace App\Models\Peta;

use App\Enumerations\TipePeta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class PetaKategori extends Model
{
    use HasFactory;

    protected $casts = ['tipe' => TipePeta::class];

    protected $fillable = ['nama', 'keterangan', 'tipe', 'simbol_id', 'warna_id'];

    protected $table = 'peta_kategori';

    protected function warna(): BelongsTo
    {
        return $this->belongsTo(PetaWarna::class);
    }

    public function simbol(): BelongsTo
    {
        return $this->belongsTo(PetaSimbol::class);
    }

    public function titik(): MorphToMany
    {
        return $this->modelHasSidBantuan(PetaTitik::class);
    }

    public function garis(): MorphToMany
    {
        return $this->modelHasSidBantuan(PetaGaris::class);
    }

    public function area(): MorphToMany
    {
        return $this->modelHasSidBantuan(PetaArea::class);
    }

    public function peta(): MorphToMany
    {
        if (!empty($this->tipe)) {
            return $this->modelHasSidBantuan($this->tipe->value);
        }

        return $this->titik();
    }

    protected function modelHasSidBantuan($model): MorphToMany
    {
        return $this->morphedByMany($model, 'peta_model_has_kategori', 'peta_model_has_kategori');
    }
}
