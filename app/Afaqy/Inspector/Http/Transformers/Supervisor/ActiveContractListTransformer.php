<?php

namespace Afaqy\Inspector\Http\Transformers\Supervisor;

use League\Fractal\TransformerAbstract;

class ActiveContractListTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'     => $data->id,
            'number' => 'عقد ' . $data->contract_number,
        ];
    }
}
