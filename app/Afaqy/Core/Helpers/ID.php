<?php

namespace Afaqy\Core\Helpers;

class ID
{
    /**
     * @return int
     */
    public function generate()
    {
        return hexdec(uniqid());
    }
}
