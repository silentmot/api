<?php

namespace Afaqy\WasteType\Http\Transformers;

use League\Fractal\TransformerAbstract;
use Afaqy\Zone\Http\Transformers\ZoneTransformer;

class WasteTypeShowTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'unitsCount', 'scaleZones',
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
            'zone_id' => $data[0]['zone_id'],
            'pit_id'  => $data[0]['pit_id'],
        ];
    }

    /**
     * Transform units count.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includeUnitsCount($data)
    {
        return $this->primitive((int) $data['units_count']);
    }

    /**
     * Transform scalezones.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\collection
     */
    public function includescaleZones($data)
    {
        foreach ($data as $key => $value) {
            $newData [] = [
                'id'   => $data[$key]['scale_zone_id'],
                'name' => $data[$key]['scale_zone_name'],
            ];
        }

        return $this->collection($newData, new ZoneTransformer, false);
    }
}
