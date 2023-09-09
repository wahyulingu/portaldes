<?php

namespace App\Traits\Action;

use App\Contracts\Model\HasPicture;
use Illuminate\Database\Eloquent\Model;

trait SetPictureable
{
    /**
     * Summary of pictureable.
     */
    private Model&HasPicture $pictureable;

    /**
     * Summary of setPictureable.
     */
    public function prepare(HasPicture $pictureable): self
    {
        $this->pictureable = $pictureable;

        return $this;
    }

    protected function getPictureable(): Model&HasPicture
    {
        return $this->pictureable;
    }
}
