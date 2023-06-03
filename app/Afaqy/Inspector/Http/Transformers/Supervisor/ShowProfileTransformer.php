<?php

namespace Afaqy\Inspector\Http\Transformers\Supervisor;

use League\Fractal\TransformerAbstract;

class ShowProfileTransformer extends TransformerAbstract
{
    /**
     * @param mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'    => (int) $data['id'],
            'name'  => (string) $data['name'],
            'email' => (string) $data['email'],
            'phone' => (string) $data['phone'],
        ];
    }
}
