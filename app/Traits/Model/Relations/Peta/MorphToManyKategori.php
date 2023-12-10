<?php

namespace App\Traits\Model\Relations\Peta;

use App\Models\Peta\PetaKategori;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait MorphToManyKategori
{
    /**
     * A model may have multiple categories.
     */
    public function kategori(): MorphToMany
    {
        return $this->morphToMany(PetaKategori::class, 'peta_model_has_kategori', 'peta_model_has_kategori');
    }
}
