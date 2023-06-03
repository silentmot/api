<?php

namespace Afaqy\EntrancePermission\Http\Transformers;

use Illuminate\Support\Carbon;
use League\Fractal\TransformerAbstract;

class EntrancePermissionTransformer extends TransformerAbstract
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
            'name'          => $data['name'],
            'type'          => $data['type'],
            'plate_number'  => $data['plate_number'],
            'start_date'    => Carbon::parse($data['start_date'])->format('d-m-Y'),
            'end_date'      => Carbon::parse($data['end_date'])->format('d-m-Y'),
        ];
    }
}
