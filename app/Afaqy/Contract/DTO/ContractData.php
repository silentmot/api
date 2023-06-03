<?php

namespace Afaqy\Contract\DTO;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class ContractData extends FlexibleDataTransferObject
{
    /**
     * @var int|null
     */
    public $id = null;

    /**
     * @var int
     */
    public $contractor_id;

    /**
     * @var string
     */
    public $start_at;

    /**
     * @var string
     */
    public $end_at;

    /**
     * @var int
     */
    public $contract_number;

    /**
     * @var bool
     */
    public $status = true;

    /**
     * @var \Afaqy\Contact\DTO\ContractContactData
     */
    public $contact;

    /**
     * @var \Afaqy\Contract\DTO\ContractDistrictData[]
     */
    public $districts;

    /**
     * @var \Afaqy\Contract\DTO\ContractStationData[]|null
     */
    public $stations;

    /**
     * Prepare data transfer object for the given request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int|null                 $id
     * @return self
     */
    public static function fromRequest(Request $request, ? int $id = null) : self
    {
        $status = $request->status ?? true;

        $start_at = Carbon::parse($request->start_at);
        $end_at   = Carbon::parse($request->end_at);

        if ($end_at->lessThan(Carbon::today()) || $start_at->greaterThan(Carbon::today())) {
            $status = false;
        }

        return new self([
            'id'              => $id ?? null,
            'start_at'        => $request->start_at,
            'end_at'          => $request->end_at,
            'status'          => $status,
            'contractor_id'   => $request->contractor_id,
            'contract_number' => $request->contract_number,
            'contact'         => $request->contact,
            'districts'       => $request->districts,
            'stations'        => $request->stations,
        ]);
    }
}
