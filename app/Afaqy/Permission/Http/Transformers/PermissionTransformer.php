<?php

namespace Afaqy\Permission\Http\Transformers;

use League\Fractal\TransformerAbstract;

class PermissionTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'                => (int) $data['id'],
            'permission_number' => (int) $data['permission_number'],
            'permission_type'   => (string) $data['permission_type'],
            'type'              => (string) $data['type'] ? $data['type'] : trans("permission::permission.permission-types.{$data['permission_type']}"),
            'allowed_weight'    => (int) $data['allowed_weight'] ?? null,
            'actual_weight'     => (int) $data['actual_weight'],
        ];
    }
}
