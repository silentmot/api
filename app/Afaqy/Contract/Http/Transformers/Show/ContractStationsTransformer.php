<?php

namespace Afaqy\Contract\Http\Transformers\Show;

use League\Fractal\TransformerAbstract;

class ContractStationsTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        $result = [
            'station_id'       => $data[0]['station_id'],
            'station_name'     => $data[0]['station_name'],
        ];

        foreach ($data as $key => $unit) {
            $result['units'][$key]['id']           = $unit['unit_id'];
            $result['units'][$key]['plate_number'] = $unit['plate_number'];
        }

        return $result;
    }
}
