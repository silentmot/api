<?php

namespace Afaqy\Contract\Http\Transformers\Show;

use League\Fractal\TransformerAbstract;

class ContractContractorTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'   => $data['id'],
            'name' => $data['name_ar'],
        ];
    }
}
