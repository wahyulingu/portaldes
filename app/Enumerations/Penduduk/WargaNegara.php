<?php

namespace App\Enumerations\Penduduk;

use App\Traits\Enum\Finder;

enum WargaNegara: string
{
    use Finder;

    case wni = 'WNI';
    case wna = 'WNA';
    case dua = 'Dua Kewarganegaraan';
}
