<?php

namespace App\Enumerations\Penduduk;

use App\Traits\Enum\Finder;

enum Status: string
{
    use Finder;

    case tetap = 'Tetap';
    case tidakTetap = 'Tidak Tetap';
    case pendatang = 'Pendatang';
}
