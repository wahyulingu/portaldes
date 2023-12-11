<?php

namespace App\Actions\Peta\Titik;

use App\Abstractions\Action\Peta\PetaIndexAction;
use App\Repositories\Peta\PetaTitikRepository;

class TitikIndexAction extends PetaIndexAction
{
    public function __construct(PetaTitikRepository $repository)
    {
        parent::__construct($repository);
    }
}
