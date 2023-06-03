<?php

namespace Afaqy\TransitionalStation\Http\Transformers;

use League\Fractal\TransformerAbstract;

class TransitionalStationContractsTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'   => $data['id'],
            'name' => 'عقد ' . $data['contract_number'],
        ];
    }
}
