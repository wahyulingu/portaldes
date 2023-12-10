<?php

namespace App\Enumerations;

use App\Models\Sid\Kelompok\SidPendudukKelompok;
use App\Models\Sid\SidKeluarga;
use App\Models\Sid\SidPenduduk;
use App\Traits\Enum\Finder;

enum SasaranBantuan: string
{
    use Finder;

    case penduduk = SidPenduduk::class;
    case keluarga = SidKeluarga::class;
    case kelompok = SidPendudukKelompok::class;
}
