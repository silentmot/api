<?php

namespace Afaqy\User\Http\Transformers;

use League\Fractal\TransformerAbstract;

class UserShowTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'role',
    ];

    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'         => (int) $data['user_id'],
            'username'   => (string) $data['username'],
            'first_name' => (string) $data['first_name'],
            'last_name'  => (string) $data['last_name'],
            'email'      => (string) $data['email'],
            'phone'      => (string) $data['phone'],
            'status'     => (int) ($data['status']),
            'use_mob'    => (int) ($data['use_mob']),
        ];
    }

    /**
     * Transform role .
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\primitive
     */
    public function includeRole($data)
    {
        return $this->primitive((int) $data['role']);
    }
}
