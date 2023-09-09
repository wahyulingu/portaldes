<?php

namespace App\Enumerations\Medis\Kelahiran;

use App\Traits\Enum\Finder;

enum Tempat: string
{
    use Finder;

    case rumahsakit = 'Rumah Sakit/Rumah Bersalin';
    case puskesmas = 'Puskesmas';
    case polindes = 'Polindes';
    case rumah = 'Rumah';
    case lainya = 'Lainnya';
}
