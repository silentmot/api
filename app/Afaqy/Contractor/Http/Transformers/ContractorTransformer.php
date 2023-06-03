<?php

namespace Afaqy\Contractor\Http\Transformers;

use League\Fractal\TransformerAbstract;

class ContractorTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'unitsCount', 'contact',
    ];

    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'         => (int) $data['contractor_id'],
            'name_en'    => (string) $data['name_en'],
            'name_ar'    => (string) $data['name_ar'],
            'employees'  => (is_null($data['employees'])) ?  $data['employees'] : (int) $data['employees'],
        ];
    }

    /**
     * Transform units count.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includeUnitsCount($data)
    {
        return $this->primitive((int) $data['units_count']);
    }

    /**
     * Transform contacts.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includeContact($data)
    {
        return $this->Primitive([
            'id'          => (int) $data['contact_id'],
            'name'        => (string) $data['name'],
            'email'       => (string) $data['email'],
            'phone'       => (string) $data['phone'],
        ]);
    }
}
