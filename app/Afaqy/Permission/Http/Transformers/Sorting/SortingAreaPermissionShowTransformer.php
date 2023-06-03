<?php

namespace Afaqy\Permission\Http\Transformers\Sorting;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Afaqy\Permission\Http\Transformers\PermissionUnitTransformer;

class SortingAreaPermissionShowTransformer extends TransformerAbstract
{
    protected $total_weight = 0;

    /**
     * @var array
     */
    protected $availableIncludes = [
        'units',
        'totalWeight',
    ];

    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'                        => (int) $data[0]['permission_id'],
            'permission_number'         => (string) $data[0]['permission_id'],
            'entity_name'               => (string) $data[0]['entity_name'],
            'representative_name'       => (string) $data[0]['representative_name'],
            'national_id'               => (int) $data[0]['national_id'],
            'allowed_weight'            => (int) $data[0]['allowed_weight'],
            'waste_type_name'           => (string) $data[0]['waste_type_name'],
        ];
    }

    /**
     * Transform units.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\collection
     */
    public function includeUnits($data)
    {
        $total_weight = 0;

        foreach ($data as $key => $value) {
            $newData[]    = [
                'id'               => $data[$key]['unit_id'],
                'plate_number'     => $data[$key]['plate_number'],
                'qr_code'          => $data[$key]['qr_code'],
                'rfid'             => $data[$key]['rfid'],
                'weight'           => $data[$key]['weight'],
                'checkin_time'     => $data[$key]['start_time'] ? Carbon::parse($data[$key]['start_time'])->toDateString() : null,
            ];
            $total_weight += $data[$key]['weight'];
        }

        $this->total_weight = $total_weight;

        return $this->collection($newData, new PermissionUnitTransformer, false);
    }

    /**
     * Transform units.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\primitive
     */
    public function includeTotalWeight($data)
    {
        return $this->primitive($this->total_weight);
    }
}
