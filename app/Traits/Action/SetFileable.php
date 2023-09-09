<?php

namespace App\Traits\Action;

use App\Contracts\Model\HasFile;
use Illuminate\Database\Eloquent\Model;

trait SetFileable
{
    /**
     * Summary of fileable.
     */
    private Model&HasFile $fileable;

    /**
     * Summary of setFileable.
     */
    public function setFileable(HasFile $fileable): self
    {
        $this->fileable = $fileable;

        return $this;
    }

    protected function getFileable(): Model&HasFile
    {
        return $this->fileable;
    }
}
