<?php

namespace Afaqy\Inspector\DTO;

use Illuminate\Http\Request;
use Afaqy\Contract\Models\Contract;
use Spatie\DataTransferObject\DataTransferObject;

class TicketData extends DataTransferObject
{
    /**
     * @var int
     */
    public $user_id;

    /**
     * @var int
     */
    public $district_id;

    /**
     * @var int
     */
    public $neighborhood_id;

    /**
     * @var int
     */
    public $contract_id;

    /**
     * @var string
     */
    public $contractor_name;

    /**
     * @var string
     */
    public $location;

    /**
     * @var string
     */
    public $location_name;

    /**
     * @var string|null
     */
    public $details;

    /**
     * @var $status
     */
    public $status;

    /**
     * Prepare data transfer object for the given request.
     *
     * @param Request $request
     * @return self
     */
    public static function fromRequest(Request $request): self
    {
        $contract = Contract::findOrFail($request->contract_id);

        return new self([
            'user_id'              => auth()->id(),
            'district_id'          => $request->district_id,
            'neighborhood_id'      => $request->neighborhood_id,
            'contract_id'          => $request->contract_id,
            'contractor_name'      => $contract->contractor->name_ar,
            'location'             => $request->location,
            'location_name'        => $request->location_name,
            'details'              => $request->details,
            'status'               => "PENDING",
        ]);
    }
}
