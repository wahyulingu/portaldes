<?php

namespace App\Actions\Peta\Simbol;

use App\Abstractions\Action\Peta\PetaIndexAction;
use App\Repositories\Peta\PetaSimbolRepository;

class SimbolIndexAction extends PetaIndexAction
{
    public function __construct(PetaSimbolRepository $repository)
    {
        parent::__construct($repository);
    }
}
