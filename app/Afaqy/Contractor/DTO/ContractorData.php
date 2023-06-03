<?php

namespace Afaqy\Contractor\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class ContractorData extends FlexibleDataTransferObject
{
    /** @var int|null */
    public $id = null;

    /** @var string */
    public $name_en;

    /** @var string */
    public $name_ar;

    /** @var string|null */
    public $address;

    /** @var int|null */
    public $commercial_number;

    /** @var integer|null */
    public $employees;

    /** @var string|null */
    public $avl_company;

    /**
     * @var \Afaqy\Contact\DTO\ContactData[]
     */
    public $contacts;

    /**
     * Prepare data transfer object for the given request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int|null $id
     * @return self
     */
    public static function fromRequest(Request $request, ?int $id = null): self
    {
        return new self([
            'id'                => $id ?? null,
            'name_ar'           => ((string) $request->name_ar),
            'name_en'           => ((string) $request->name_en),
            'employees'         => (is_null($request->employees)) ? $request->employees : (int) $request->employees,
            'commercial_number' => (is_null($request->commercial_number)) ? $request->commercial_number : (int) $request->commercial_number,
            'address'           => ((string) $request->address),
            'contacts'          => $request->contacts,
            'avl_company'       => $request->avl_company,
        ]);
    }
}
