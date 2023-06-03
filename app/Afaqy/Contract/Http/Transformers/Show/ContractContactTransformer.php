<?php

namespace Afaqy\Contract\Http\Transformers\Show;

use League\Fractal\TransformerAbstract;

class ContractContactTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'    => $data['id'],
            'name'  => $data['name'],
            'title' => $data['title'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ];
    }
}
