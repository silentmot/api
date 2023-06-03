<?php

namespace Afaqy\Unit\DTO;

use Afaqy\Unit\Models\Unit;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class UnitData extends FlexibleDataTransferObject
{
    /** @var int|null */
    public $id;

    /** @var string */
    public $code;

    /** @var int|null */
    public $model;

    /** @var string */
    public $plate_number;

    /** @var string|null */
    public $vin_number;

    /** @var mixed */
    public $net_weight;

    /** @var mixed */
    public $max_weight;

    /** @var int|null */
    public $rfid = null;

    /** @var int|null */
    public $qr_code = null;

    /** @var int */
    public $unit_type_id;

    /** @var int */
    public $waste_type_id;

    /** @var int */
    public $contractor_id;

    /** @var bool */
    public $active;

    /**
     * Prepare data transfer object for the given request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int|null $id
     * @return self
     */
    public static function fromRequest(Request $request, ?int $id = null): self
    {
        if ($id) {
            $unit = Unit::findOrFail($id);
        }

        return new self([
            "id"            => $id ?? null,
            "code"          => $request->code ?? $unit->code,
            'model'         => (is_null($request->model)) ? $request->model : (int) $request->model,
            "plate_number"  => $request->plate_number ?? $unit->plate_number,
            "vin_number"    => (is_null($request->vin_number)) ? $request->vin_number : (string) $request->vin_number,
            "net_weight"    => $request->net_weight ?? $unit->net_weight,
            "max_weight"    => $request->max_weight ?? $unit->max_weight,
            "rfid"          => ($request->has('rfid')) ? $request->rfid : $unit->rfid ?? null,
            "qr_code"       => $request->qr_code ?? null,
            "unit_type_id"  => $request->unit_type ?? $unit->unit_type,
            "waste_type_id" => $request->waste_type ?? $unit->waste_type,
            "contractor_id" => $request->contractor_id ?? $unit->contractor,
            "active"        => $request->active ?? $unit->active,
        ]);
    }
}
