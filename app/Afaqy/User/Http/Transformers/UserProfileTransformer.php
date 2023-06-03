<?php

namespace Afaqy\User\Http\Transformers;

use League\Fractal\TransformerAbstract;

class UserProfileTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'         => (int) $data['user_id'],
            'full_name'  => (string) $data['full_name'],
            'username'   => (string) $data['username'],
            'email'      => (string) $data['email'],
            'phone'      => (string) $data['phone'],
            'avatar'     => (string) ($data['avatar']) ? route('image.show', explode('/', $data['avatar'])) : null,
            'status'     => (int) ($data['status']) ,
        ];
    }
}
