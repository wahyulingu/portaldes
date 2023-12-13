<?php

namespace App\Actions\Peta\Garis;

use App\Abstractions\Action\Peta\PetaIndexAction;
use App\Repositories\Peta\PetaGarisRepository;

class GarisIndexAction extends PetaIndexAction
{
    public function __construct(PetaGarisRepository $repository)
    {
        parent::__construct($repository);
    }
}
