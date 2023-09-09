<?php

namespace App\Enumerations\Pendidikan;

use App\Traits\Enum\Finder;

enum Tempuh: string
{
    use Finder;

    case belumTK = 'Belum Masuk TK/Kelompok Bermain';
    case sedangTK = 'Sedang TK/Kelompok Bermain';
    case tidakSekolah = 'Tidak Pernah Sekolah';
    case sdangSD = 'Sedang SD/Sederajat';
    case tidakTamatSD = 'Tidak Tamat SD/Sederajat';
    case sedangSLTP = 'Sedang SLTP/Sederajat';
    case sedangSLTA = 'Sedang SLTA/Sederajat';
    case sedangD1 = 'Sedang D-I/Sederajat';
    case sedangD2 = 'Sedang D-II/Sederajat';
    case sedangD3 = 'Sedang D-III/Sederajat';
    case sedangS1 = 'Sedang S1/Sederajat';
    case sedangS2 = 'Sedang S2/Sederajat';
    case sedangS3 = 'Sedang S3/Sederajat';
}
