<?php

namespace App\Enumerations\Penduduk\Status;

use App\Traits\Enum\Finder;

enum Ktp: string
{
    use Finder;

    case belumektp = 'Belum eKTP';
    case ektp = 'eKTP';
    case belumRekam = 'Belum Rekam';
    case sudahRekam = 'Sudah Rekam';
    case printed = 'Printed';
    case printReadyRecord = 'Print Ready Record';
    case shipped = 'Card Shipped';
    case sendForPrinting = 'Send for Card Printing';
    case issued = 'Card Issued';
}
