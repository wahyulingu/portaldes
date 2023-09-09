<?php

namespace App\Enumerations\Penduduk;

use App\Traits\Enum\Finder;

enum HubunganKeluarga: string
{
    use Finder;

    case kepala = 'Kepala Keluarga';
    case suami = 'Suami';
    case istri = 'Isteri';
    case anak = 'Anak';
    case menantu = 'Menantu';
    case cucu = 'Cucu';
    case orangtua = 'Orang Tua';
    case mertua = 'Mertua';
    case famili = 'Famili';
    case pembantu = 'Pembantu';
    case lainnya = 'Lainnya';
}
