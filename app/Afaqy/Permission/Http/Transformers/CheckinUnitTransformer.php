<?php

namespace Afaqy\Permission\Http\Transformers;

use League\Fractal\TransformerAbstract;

class CheckinUnitTransformer extends TransformerAbstract
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
            'id'           => (int) $data['id'],
            'plate_number' => (string) $data['plate_number'],
            'qr_code'      => $data['qr_code'],
            'rfid'         => $data['rfid'] ?? null,
        ];
    }
}
