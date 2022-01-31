<?php

namespace AsposeImagingConverter\ConvToWebP;

use RecursiveFilterIterator;

class Iterator extends RecursiveFilterIterator
{
    public function accept()
    {
        $path = $this->current()->getPathname();
        return true;
    }
}

