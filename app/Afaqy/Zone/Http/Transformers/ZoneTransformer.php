<?php

namespace Afaqy\Zone\Http\Transformers;

use League\Fractal\TransformerAbstract;

class ZoneTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'devicesNames',
        'direction',
        'scaleName',
    ];

    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data, $show = false): array
    {
        return [
            'id'    => $data['id'],
            'name'  => $data['name'],
        ];
    }

    /**
     * Transform scale name.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includeScaleName($data)
    {
        return $this->primitive($data['scale_name']);
    }

    /**
     * Transform gates names.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includeDirection($data)
    {
        return $this->primitive($data['direction']);
    }

    /**
     * Transform devices names.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includeDevicesNames($data)
    {
        return $this->primitive(explode(',', $data['devices_names']));
    }
}
