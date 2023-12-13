<?php

namespace App\Actions\Peta\Kategori;

use App\Abstractions\Action\Peta\PetaIndexAction;
use App\Repositories\Peta\PetaKategoriRepository;

class KategoriIndexAction extends PetaIndexAction
{
    public function __construct(PetaKategoriRepository $repository)
    {
        parent::__construct($repository);
    }
}
