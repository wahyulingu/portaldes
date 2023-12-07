<?php

namespace App\Models\Sid\Surat;

use App\Contracts\Model\HasSuratContract;
use App\Traits\Model\HasRepository;
use App\Traits\Model\Relations\Sid\MorphOneSidSurat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SidSuratLampiran extends Model implements HasSuratContract
{
    use HasFactory;
    use HasRepository;
    use MorphOneSidSurat;
}
