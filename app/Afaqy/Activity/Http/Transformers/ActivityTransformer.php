<?php

namespace Afaqy\Activity\Http\Transformers;

use League\Fractal\TransformerAbstract;

class ActivityTransformer extends TransformerAbstract
{
    /**
     * @param mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'old'         => $data['properties']['old'] ?? (object) [],
            'new'         => $data['properties']['attributes'],
        ];
    }
}
