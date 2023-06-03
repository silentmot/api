<?php

namespace Afaqy\TripWorkflow\Http\Transformers;

use League\Fractal\TransformerAbstract;

class EntranceScaleZonesTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'devices',
        'scales',
    ];

    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'id'      => $data->id,
            'name'    => $data->name,
            'message' => [
                'sound' => $data->message_id,
                'text'  => config('tripworkflow.message.' . $data->message_id),
            ],
        ];
    }

    /**
     * Transform zone devices.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includeDevices($data)
    {
        return $this->primitive([
            'ip'        => $data->device_ip,
            'serial'    => $data->serial,
            'type'      => $data->device_type,
            'direction' => $data->direction,
            'duration'  => $data->duration,
            'door_name' => $data->door_name,
        ]);
    }

    /**
     * Transform zone scales.
     *
     * @param mixed  $data
     * @return \League\Fractal\Resource\Primitive
     */
    public function includeScales($data)
    {
        return $this->primitive([
            'ip'          => $data->scale_ip,
            'com_port'    => $data->com_port,
            'baud_rate'   => $data->baud_rate,
            'parity'      => $data->parity,
            'data_bits'   => $data->data_bits,
            'stop_bits'   => $data->stop_bits,
            'start_read'  => $data->start_read,
            'end_read'    => $data->end_read,
            'service_url' => $data->service_url,
        ]);
    }
}
