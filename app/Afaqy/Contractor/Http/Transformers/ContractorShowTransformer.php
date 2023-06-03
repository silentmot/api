<?php

namespace Afaqy\Contractor\Http\Transformers;

use League\Fractal\TransformerAbstract;
use Afaqy\Contact\Http\Transformers\ContactShowTransformer;

class ContractorShowTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'contacts',

    ];

    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'                 => $data[0]['contractor_id'],
            'name_en'            => $data[0]['name_en'],
            'name_ar'            => $data[0]['name_ar'],
            'employees'          => (is_null($data[0]['employees'])) ?  $data[0]['employees'] : (int) $data[0]['employees'],
            'commercial_number'  => $data[0]['commercial_number'],
            'address'            => $data[0]['address'],
            'avl_company'        => $data[0]['avl_company'],
        ];
    }

    /**
     * Transform contacts.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\collection
     */
    public function includeContacts($data)
    {
        foreach ($data as $key => $value) {
            $newData[] = [
                'id'               => $data[$key]['contact_id'],
                'name'             => $data[$key]['name'],
                'email'            => $data[$key]['email'],
                'default_contact'  => $data[$key]['default_contact'],
                'phones'           => $data[$key]['phones'],
            ];
        }

        return $this->collection($newData, new ContactShowTransformer, false);
    }
}
