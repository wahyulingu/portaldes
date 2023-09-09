<?php

namespace App\Enumerations\Penduduk;

use App\Traits\Enum\Finder;

enum Agama: string
{
    use Finder;

    case islam = 'Islam';
    case kristen = 'Kristen';
    case katholik = 'Katholik';
    case hindu = 'Hindu';
    case budha = 'Budha';
    case khonghucu = 'Khonghucu';
    case lainnya = 'Kepercayaan Lainnya';
}
