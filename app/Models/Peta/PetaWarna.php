<?php

namespace App\Models\Peta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetaWarna extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'keterangan', 'kode'];

    protected $table = 'peta_warna';
}
