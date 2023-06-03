<?php

namespace Afaqy\TripWorkflow\Actions;

use Afaqy\Zone\Models\Zone;
use Afaqy\Core\Actions\Action;
use Afaqy\Device\Models\Device;

class GetZoneInformationFromIpAction extends Action
{
    /**
     * @var string
     */
    private $ip;

    /**
     * @param string $ip
     * @return void
     */
    public function __construct($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $device = Device::select('zone_id')->where('devices.ip', $this->ip)->first();

        $zone = Zone::withMachines()
            ->select([
                'zones.id',
                'zones.message_id',
                'zones.type',
                'devices.ip as device_ip',
                'devices.serial',
                'devices.type as device_type',
                'devices.direction',
                'devices.duration',
                'devices.door_name',
                'scales.ip as scale_ip',
                'scales.com_port',
                'scales.baud_rate',
                'scales.parity',
                'scales.data_bits',
                'scales.stop_bits',
                'scales.start_read',
                'scales.end_read',
                'scales.service_url',
            ])
            ->where('zones.id', $device->zone_id)
            ->get();

        return $this->format($zone);
    }

    private function format($zone)
    {
        $data['zone'] = [
            'id'   => $zone->first()->id,
            'type' => $zone->first()->type,
        ];

        $data['zone']['request']['device_ip'] = $this->ip;

        foreach ($zone as $key => $device) {
            $data['zone']['devices'][$device->device_type] = [
                'ip'        => $device->device_ip,
                'type'      => $device->device_type,
                'serial'    => $device->serial,
                'gate_name' => $device->door_name,
                'direction' => $device->direction,
                'duration'  => $device->duration,
            ];
        }

        if ($zone->first()->scale_ip) {
            $data['zone']['scale'] = [
                'ip'          => $zone->first()->scale_ip,
                'com_port'    => $zone->first()->com_port,
                'baud_rate'   => $zone->first()->baud_rate,
                'parity'      => $zone->first()->parity,
                'data_bits'   => $zone->first()->data_bits,
                'stop_bits'   => $zone->first()->stop_bits,
                'start_read'  => $zone->first()->start_read,
                'end_read'    => $zone->first()->end_read,
                'service_url' => $zone->first()->service_url,
            ];
        }

        return $data;
    }
}
