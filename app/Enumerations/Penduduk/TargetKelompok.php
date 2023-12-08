<?php

namespace App\Enumerations\Penduduk;

use App\Models\Sid\Penduduk\SidPenduduk;
use App\Models\Sid\SidKeluarga;
use App\Traits\Enum\Finder;

enum TargetKelompok: string
{
    use Finder;

    case penduduk = SidPenduduk::class;
    case keluarga = SidKeluarga::class;
}
