<?php

namespace Afaqy\Role\Http\Transformers;

use League\Fractal\TransformerAbstract;

class NotificationTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'           => $data->id,
            'name'         => $data->name,
            'display_name' => $data->display_name,
        ];
    }
}
