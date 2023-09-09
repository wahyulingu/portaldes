<?php

namespace App\Traits\Action;

use Illuminate\Support\Collection;

trait SetCollection
{
    private Collection $collection;

    public function setCollection(Collection $collection)
    {
        $this->collection = $collection;

        return $this;
    }

    public function getCollection(): Collection
    {
        return $this->collection;
    }
}
