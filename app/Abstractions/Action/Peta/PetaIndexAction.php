<?php

namespace App\Abstractions\Action\Peta;

use App\Abstractions\Action\IndexAction;
use App\Abstractions\Repository\PetaRepository;

abstract class PetaIndexAction extends IndexAction
{
    public function __construct(PetaRepository $repository)
    {
        parent::__construct($repository);
    }
}
