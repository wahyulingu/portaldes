<?php

namespace App\Actions\Peta\Warna;

use App\Abstractions\Action\Peta\PetaIndexAction;
use App\Repositories\Peta\PetaWarnaRepository;

class WarnaIndexAction extends PetaIndexAction
{
    public function __construct(PetaWarnaRepository $repository)
    {
        parent::__construct($repository);
    }
}
