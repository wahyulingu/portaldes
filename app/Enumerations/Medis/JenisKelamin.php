<?php

namespace App\Enumerations\Medis;

use App\Traits\Enum\Finder;

enum JenisKelamin: string
{
    use Finder;

    case laki = 'Laki-Laki';
    case perempuan = 'Perempuan';
}
