<?php

namespace Afaqy\Permission\Http\Transformers\Individual;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Afaqy\Permission\Http\Transformers\PermissionUnitTransformer;

class IndividualPermissionShowTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'units',
        'totalWeight',
    ];

    private $total_weight = 0;

    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'                 => (int) $data[0]['permission_id'],
            'demolition_serial'  => (int) $data[0]['demolition_serial'],
            'permission_number'  => (int) $data[0]['permission_number'],
            'type'               => (string) $data[0]['type'],
            'permission_date'    => (string) Carbon::parse($data[0]['permission_date'])->format('d-m-Y'),
            'district_name'      => (string) $data[0]['district_name'],
            'neighborhood_name'  => (string) $data[0]['neighborhood_name'],
            'owner_name'         => (string) $data[0]['owner_name'],
            'owner_phone'        => (string) $data[0]['owner_phone'],
            'street'             => (string) $data[0]['street'],
            'national_id'        => (int) $data[0]['national_id'],
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
