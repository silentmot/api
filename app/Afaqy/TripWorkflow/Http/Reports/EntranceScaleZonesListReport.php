<?php

namespace Afaqy\TripWorkflow\Http\Reports;

use Afaqy\Zone\Models\Zone;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\TripWorkflow\Http\Transformers\EntranceScaleZonesTransformer;

class EntranceScaleZonesListReport extends Report
{
    use Generator;

    /**
     * @return mixed
     */
    public function generate()
    {
        return $this->generateSelectList(
            $this->query(),
            new EntranceScaleZonesTransformer,
            ['devices', 'scales']
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Zone::withMachines()
            ->select([
                'zones.id',
                'zones.name',
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
            ->where('zones.type', 'entranceScale');
    }
}
