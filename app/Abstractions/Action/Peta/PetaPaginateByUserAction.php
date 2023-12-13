<?php

namespace App\Abstractions\Action\Peta;

use App\Contracts\Action\PaginatedIndexContract;

abstract class PetaPaginateByUserAction extends PetaIndexByUserAction implements PaginatedIndexContract
{
}
