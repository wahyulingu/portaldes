<?php

namespace App\Models\Sid\Surat;

use App\Contracts\Model\MorphOneSurat;
use App\Traits\Model\Relations\Sid\MorphOneSidSurat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SidSuratKeluar extends Model implements MorphOneSurat
{
    use HasFactory;
    use MorphOneSidSurat;

    protected $guarded = ['id'];
    protected $table = 'sid_surat_keluar';
}
