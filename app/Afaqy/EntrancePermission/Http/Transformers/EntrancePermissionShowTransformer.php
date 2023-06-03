<?php

namespace Afaqy\EntrancePermission\Http\Transformers;

use Illuminate\Support\Carbon;
use League\Fractal\TransformerAbstract;

class EntrancePermissionShowTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'            => $data['id'],
            'type'          => $data['type'],
            'name'          => $data['name'],
            'title'         => $data['title'],
            'national_id'   => $data['national_id'],
            'company'       => $data['company'],
            'phone'         => $data['phone'],
            'plate_number'  => $data['plate_number'],
            'start_date'    => Carbon::parse($data['start_date'])->format('d-m-Y'),
            'end_date'      => Carbon::parse($data['end_date'])->format('d-m-Y'),
            'rfid'          => $data['rfid'],
            'qr_code'       => $data['qr_code'],
        ];
    }
}
