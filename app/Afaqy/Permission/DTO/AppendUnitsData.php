<?php

namespace Afaqy\Permission\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class AppendUnitsData extends FlexibleDataTransferObject
{
    /** @var int */
    public $number;

    /** @var mixed */
    public $model;

    /**
     * @var \Afaqy\Permission\DTO\UnitData[]
     */
    public $units;

    /**
     * Prepare data transfer object for the given request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $model
     * @param  int $number
     * @return self
     */
    public static function fromRequest(Request $request, $model, int $number): self
    {
        return new self([
            'number' => $number,
            'model'  => $model,
            'units'  => $request->units,
        ]);
    }
}
