<?php

namespace App\Enumerations\Medis;

use App\Traits\Enum\Finder;

enum Cacat: string
{
    use Finder;

    case fisik = 'Cacat Fisik';
    case netra = 'Cacat Netra/Buta';
    case rungu = 'Cacat Rungu/Wicara';
    case mental = 'Cacat Mental/Jiwa';
    case fisikMental = 'Cacat Fisik dan Mental';
    case lainnya = 'Cacat Lainnya';
    case tidak = 'Tidak Cacat';
}
