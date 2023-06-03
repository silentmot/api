<?php

namespace Afaqy\Contract\Http\Transformers\Show;

use League\Fractal\TransformerAbstract;

class ContractShowTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'contractor',
        'contact',
        'districts',
    ];

    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'              => $data['id'],
            'contract_number' => $data['contract_number'],
            'start_at'        => $data['start_at'],
            'end_at'          => $data['end_at'],
            'status'          => $data['status'],
        ];
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
            'id'   => $data[0]['contractor_id'],
            'name' => $data[0]['contractor_name'],
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
            'id'    => $data[0]['contact_id'],
            'name'  => $data[0]['contact_name'],
            'title' => $data[0]['contact_title'],
            'email' => $data[0]['contact_email'],
            'phone' => $data[0]['contact_phone'],
        ]);
    }

    /**
     * Transform contractor.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includeDistricts($data)
    {
        $newdata = [];

        foreach ($data as $key => $district) {
            $units               = [];
            $units_ids           = explode(',', $district['units_ids']);
            $units_plate_numbers = explode(',', $district['units_plate_numbers']);

            foreach ($units_ids as $ukey => $id) {
                $units[$ukey]['id']           = $id;
                $units[$ukey]['plate_number'] = $units_plate_numbers[$ukey];
            }

            $newdata[$key]['district_id']       = $district['district_id'];
            $newdata[$key]['district_name']     = $district['district_name'];
            $newdata[$key]['neighborhood_id']   = $district['neighborhood_id'];
            $newdata[$key]['neighborhood_name'] = $district['neighborhood_name'];
            $newdata[$key]['units']             = $units;
        }

        return $this->primitive($newdata);
    }
}
