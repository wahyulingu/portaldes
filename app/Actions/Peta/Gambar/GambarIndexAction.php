<?php

namespace App\Actions\Peta\Gambar;

use App\Abstractions\Action\Peta\PetaIndexAction;
use App\Repositories\Peta\PetaGambarRepository;

class GambarIndexAction extends PetaIndexAction
{
    public function __construct(PetaGambarRepository $repository)
    {
        parent::__construct($repository);
    }
}
