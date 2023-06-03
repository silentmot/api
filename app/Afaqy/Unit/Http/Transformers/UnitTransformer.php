<?php

namespace Afaqy\Unit\Http\Transformers;

use League\Fractal\TransformerAbstract;

class UnitTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'unitTypeName',
        'wasteTypeName',
        'contractorName',
        'unitType',
        'wasteType',
        'contractor',
    ];

    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'           => $data['id'],
            'code'         => $data['code'],
            'model'        => $data['model'],
            'plate_number' => $data['plate_number'],
            'net_weight'   => $data['net_weight'],
            'active'       => $data['active'],
        ];
    }

    /**
     * Transform unit type name.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includeUnitTypeName($data)
    {
        return $this->primitive($data['unit_type_name']);
    }

    /**
     * Transform waste type name.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includeWasteTypeName($data)
    {
        return $this->primitive($data['waste_type_name']);
    }

    /**
     * Transform waste type name.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includeContractorName($data)
    {
        return $this->primitive($data['contractor_name']);
    }
}
