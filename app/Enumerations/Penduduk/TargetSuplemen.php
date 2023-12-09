<?php

namespace App\Enumerations\Penduduk;

use App\Models\Sid\SidPenduduk;
use App\Models\Sid\SidKeluarga;
use App\Traits\Enum\Finder;

enum TargetSuplemen: string
{
    use Finder;

    case penduduk = SidPenduduk::class;
    case keluarga = SidKeluarga::class;
}
