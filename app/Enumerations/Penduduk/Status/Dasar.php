<?php

namespace App\Enumerations\Penduduk\Status;

use App\Traits\Enum\Finder;

enum Dasar: string
{
    use Finder;

    case hidup = 'Hidup';
    case mati = 'Mati';
    case pindah = 'Pindah';
    case hilang = 'Hilang';
    case tidakValid = 'Tidak Valid';
}
