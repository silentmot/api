<?php

namespace Afaqy\Contact\Http\Transformers;

use League\Fractal\TransformerAbstract;

class ContactShowTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'phones',
    ];

    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'                 => (int) $data['id'],
            'name'               => (string) $data['name'],
            'email'              => (string) $data['email'],
            'default_contact'    => (boolean) $data['default_contact'],
        ];
    }

    /**
     * Transform contacts.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includePhones($data)
    {
        return $this->primitive(explode(',', $data['phones']));
    }
}
