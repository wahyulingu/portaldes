<?php

namespace App\Enumerations\Penduduk\Status;

use App\Traits\Enum\Finder;

enum Perkawinan: string
{
    use Finder;

    case belum = 'Belum Kawin';
    case kawin = 'Kawin';
    case cerai = 'Cerai Hidup';
    case mati = 'Cerai Mati';
}
