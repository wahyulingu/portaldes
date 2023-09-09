<?php

namespace App\Enumerations\Medis\Kelahiran;

use App\Traits\Enum\Finder;

enum Penolong: string
{
    use Finder;

    case dokter = 'Dokter';
    case bidan = 'Bidan';
    case dukun = 'Dukun';
    case lainnya = 'Lainnya';
}
