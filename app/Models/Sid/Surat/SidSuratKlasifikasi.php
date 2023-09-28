<?php

namespace App\Models\Sid\Surat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SidSuratKlasifikasi extends Model
{
    use HasFactory;

    protected $casts = ['enabled' => 'boolean'];

    protected $table = 'sid_surat_klasifikasi';
}
