<?php

namespace Afaqy\Scale\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class ScaleData extends FlexibleDataTransferObject
{
    /**
     * Prepare data transfer object for the given request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return self
     */
    public static function fromRequest(Request $request): self
    {
        return new self([
            //
        ]);
    }
}
