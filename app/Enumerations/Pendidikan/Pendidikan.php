<?php

namespace App\Enumerations\Pendidikan;

use App\Traits\Enum\Finder;

enum Pendidikan: string
{
    use Finder;

    case tidak = 'Tidak/Belum Sekolah';
    case belumTamatSD = 'Belum Tamat SD/Sederajat';
    case tamatSD = 'Tamat SD/Sederajat';
    case sltp = 'SLTP/Sederajat';
    case slta = 'SLTA/Sederajat';
    case diploma1d2 = 'Diploma I/II';
    case diploma3 = 'Akademi/Diploama III/S. Muda';
    case s1 = 'Diploma IV/Strata I';
    case s2 = 'Strata II';
    case s3 = 'Strata III';
}
