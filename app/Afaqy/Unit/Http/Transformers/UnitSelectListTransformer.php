<?php

namespace Afaqy\Unit\Http\Transformers;

use League\Fractal\TransformerAbstract;

class UnitSelectListTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'           => $data['id'],
            'plate_number' => $data['plate_number'],
        ];
    }
}
