<?php

namespace Afaqy\Contract\Http\Transformers;

use League\Fractal\TransformerAbstract;

class ContractTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'districtsCount',
        'unitsCount',
        'contractor',
        'contact',
    ];

    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'              => $data['id'],
            'start_at'        => $data['start_at'],
            'end_at'          => $data['end_at'],
            'contract_number' => 'عقد' .' '. $data['contract_number'],
        ];
    }

    /**
     * Transform districts count.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includeDistrictsCount($data)
    {
        return $this->primitive($data['districts_count']);
    }

    /**
     * Transform units count.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includeUnitsCount($data)
    {
        return $this->primitive($data['units_count']);
    }

    /**
     * Transform contractor.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includeContractor($data)
    {
        return $this->primitive([
            'name_ar' => $data['contractor_name_ar'],
            'name_en' => $data['contractor_name_en'],
        ]);
    }

    /**
     * Transform contractor.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includeContact($data)
    {
        return $this->primitive([
            'name'  => $data['contact_name'],
            'email' => $data['contact_email'],
            'phone' => $data['contact_phone'],
        ]);
    }
}
