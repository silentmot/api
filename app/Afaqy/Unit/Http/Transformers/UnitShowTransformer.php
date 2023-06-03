<?php

namespace Afaqy\Unit\Http\Transformers;

use Afaqy\UnitType\Http\Transformers\UnitTypeTransformer;
use Afaqy\WasteType\Http\Transformers\WasteTypeTransformer;

class UnitShowTransformer extends UnitTransformer
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        $result = parent::transform($data);

        $result['vin_number'] = (is_null($data['vin_number'])) ?  $data['vin_number'] : (string) $data['vin_number'];
        $result['max_weight'] = $data['max_weight'];
        $result['rfid']       = $data['rfid'];
        $result['qr_code']    = $data['qr_code'];

        return $result;
    }

    /**
     * Transform unit type name.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\Item
     */
    public function includeUnitType($data)
    {
        $unitType = [
            'id'   => $data['unit_id'],
            'name' => $data['unit_type'],
        ];

        return $this->item($unitType, new UnitTypeTransformer);
    }

    /**
     * Transform unit type name.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\Item
     */
    public function includeWasteType($data)
    {
        $wasteType = [
            'id'   => $data['waste_id'],
            'name' => $data['waste_type'],
        ];

        return $this->item($wasteType, new WasteTypeTransformer);
    }

    /**
     * Transform unit type name.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includeContractor($data)
    {
        return $this->primitive([
            'id'   => $data['contractor_id'],
            'name' => $data['contractor_name'],
        ]);
    }
}
