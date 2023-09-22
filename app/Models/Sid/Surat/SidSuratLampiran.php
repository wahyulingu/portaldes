<?php

namespace App\Models\Sid\Surat;

use App\Contracts\Model\MorphOneSurat;
use App\Traits\Model\Relations\Sid\MorphOneSidSurat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SidSuratLampiran extends Model implements MorphOneSurat
{
    use HasFactory;
    use MorphOneSidSurat;
}
