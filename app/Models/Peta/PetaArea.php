<?php

namespace App\Models\Peta;

use App\Traits\Model\Relations\Peta\MorphToManyKategori;
use App\Traits\Model\Relations\Peta\MorphToOneGambar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetaArea extends Model
{
    use HasFactory;
    use MorphToManyKategori;
    use MorphToOneGambar;

    protected $casts = ['path' => 'array'];

    protected $fillable = ['nama', 'keterangan', 'path', 'kategori_id'];

    protected $table = 'peta_area';
}
