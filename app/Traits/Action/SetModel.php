<?php

namespace App\Traits\Action;

use Illuminate\Database\Eloquent\Model;

trait SetModel
{
    private Model $content;

    public function setModel(ModelModel $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getModel()
    {
        return $this->content;
    }
}
