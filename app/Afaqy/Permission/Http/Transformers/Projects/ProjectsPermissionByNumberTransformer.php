<?php

namespace Afaqy\Permission\Http\Transformers\Projects;

use Illuminate\Support\Carbon;
use League\Fractal\TransformerAbstract;
use Afaqy\Permission\Http\Transformers\CheckinUnitTransformer;

class ProjectsPermissionByNumberTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'units',
    ];

    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'                        => (int) $data[0]['permission_id'],
            'demolition_serial'         => (string) $data[0]['demolition_serial'],
            'permission_number'         => (string) $data[0]['permission_number'],
            'permission_date'           => (string) Carbon::parse($data[0]['permission_date'])->format('d-m-Y'),
            'company_name'              => (string) $data[0]['company_name'],
            'company_commercial_number' => (int) $data[0]['company_commercial_number'],
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
        foreach ($data as $key => $value) {
            $newData[] = [
                'id'               => $data[$key]['unit_id'],
                'plate_number'     => $data[$key]['plate_number'],
                'qr_code'          => $data[$key]['qr_code'],
                'rfid'             => $data[$key]['rfid'],
            ];
        }

        return $this->collection($newData, new CheckinUnitTransformer, false);
    }
}
