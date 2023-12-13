<?php

namespace App\Models\Peta;

use App\Traits\Model\Relations\Peta\MorphToManyKategori;
use App\Traits\Model\Relations\Peta\MorphToOneGambar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetaTitik extends Model
{
    use HasFactory;
    use MorphToManyKategori;
    use MorphToOneGambar;

    protected $fillable = ['nama', 'keterangan', 'lat', 'lng', 'kategori_id'];
    protected $table = 'peta_titik';
}
