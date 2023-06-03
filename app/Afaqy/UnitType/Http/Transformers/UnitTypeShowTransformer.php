<?php

namespace Afaqy\UnitType\Http\Transformers;

use League\Fractal\TransformerAbstract;
use Afaqy\WasteType\Http\Transformers\WasteTypeTransformer;

class UnitTypeShowTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'wasteTypes', 'unitsCount',

    ];

    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'    => $data[0]['id'],
            'name'  => $data[0]['name'],
        ];
    }

    /**
     * Transform waste type.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\collection
     */
    public function includeWasteTypes($data)
    {
        foreach ($data as $key => $value) {
            $newData[] = [
                'id'   => $data[$key]['waste_type_id'],
                'name' => $data[$key]['waste_type_name'],
            ];
        }

        return $this->collection($newData, new WasteTypeTransformer, false);
    }
}
