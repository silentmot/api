<?php

namespace Afaqy\Permission\Http\Transformers;

use League\Fractal\TransformerAbstract;

class SerialsTransformer extends TransformerAbstract
{
    /**
     * @param  mixed   $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'serial' => (string) $data['permission_number'],
        ];
    }
}
