<?php

namespace Afaqy\Dashboard\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class DashboardData extends DataTransferObject
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
