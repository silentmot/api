<?php

namespace Afaqy\Geofence\Http\Transformers;

use League\Fractal\TransformerAbstract;

class GeofenceTransformer extends TransformerAbstract
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
            'id'           => $data['id'],
            'name'         => $data['name'],
            'type'         => $data['type'],
            'geofence_id'  => $data['geofence_id'],
        ];
    }
}
