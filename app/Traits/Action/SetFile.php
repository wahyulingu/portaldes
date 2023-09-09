<?php

namespace App\Traits\Action;

use App\Models\File;

trait SetFile
{
    private File $file;

    public function setFile(File $file)
    {
        $this->file = $file;

        return $this;
    }

    public function getFile(): File
    {
        return $this->file;
    }
}
