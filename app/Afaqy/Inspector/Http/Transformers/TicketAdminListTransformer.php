<?php

namespace Afaqy\Inspector\Http\Transformers;

use League\Fractal\TransformerAbstract;

class TicketAdminListTransformer extends TransformerAbstract
{
    /**
     * @param mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'                => $data['id'],
            'district_name'     => $data['district_name'],
            'neighborhood_name' => $data['neighborhood_name'],
            'contractor_name'   => $data['contractor_name'],
            'inspector_name'    => $data['inspector_name'],
            'created_at'        => $data['created_at'],
            'updated_at'        => $data['updated_at'],
            'status'            => $data['status'],
        ];
    }
}
