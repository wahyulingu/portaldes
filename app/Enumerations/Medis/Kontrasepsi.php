<?php

namespace App\Enumerations\Medis;

use App\Traits\Enum\Finder;

enum Kontrasepsi: string
{
    use Finder;

    case pil = 'Pil';
    case uid = 'UID';
    case suntik = 'Suntik';
    case kondom = 'Kondom';
    case spiral = 'Spiral';
    case sterilw = 'Sterilisasi Wanita';
    case sterilp = 'Sterilisasi Pria';
    case tidak = 'Tidak KB';
    case lainnya = 'Lainnya';
}
