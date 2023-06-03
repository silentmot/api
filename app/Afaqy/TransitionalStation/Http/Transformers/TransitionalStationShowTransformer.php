<?php

namespace Afaqy\TransitionalStation\Http\Transformers;

use League\Fractal\TransformerAbstract;
use Afaqy\District\Http\Transformers\DistrictTransformer;

class TransitionalStationShowTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'districts',

    ];

    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'      => $data[0]['id'],
            'name'    => $data[0]['name'],
            'status'  => $data[0]['status'],
        ];
    }

    /**
     * Transform districts.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\collection
     */
    public function includeDistricts($data)
    {
        foreach ($data as $key => $value) {
            $newData[] = [
                'id'   => $data[$key]['district_id'],
                'name' => $data[$key]['district_name'],
            ];
        }

        return $this->collection($newData, new DistrictTransformer, false);
    }
}
