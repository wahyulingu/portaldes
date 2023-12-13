<?php

namespace App\Models\Peta;

use App\Traits\Model\Relations\Peta\MorphToOneGambar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetaSimbol extends Model
{
    use HasFactory;
    use MorphToOneGambar;

    protected $fillable = ['nama', 'keterangan'];

    protected $table = 'peta_simbol';
}
