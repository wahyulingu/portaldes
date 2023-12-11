<?php

namespace App\Actions\Peta\Area;

use App\Abstractions\Action\Peta\PetaIndexAction;
use App\Repositories\Peta\PetaAreaRepository;

class AreaIndexAction extends PetaIndexAction
{
    public function __construct(PetaAreaRepository $repository)
    {
        parent::__construct($repository);
    }
}
