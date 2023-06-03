<?php

namespace Afaqy\Dashboard\Http\Transformers\Units;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Afaqy\Permission\Lookups\PermissionTypeLookup;

class UnitsDashboardRerportTransformer extends TransformerAbstract
{
    /**
     * @param  mixed   $data
     * @return array
     */
    public function transform($data): array
    {
        $lookup = PermissionTypeLookup::toArray();

        $start = Carbon::fromTimestamp($data->start_time)->toDateTimeString();
        $end   = Carbon::fromTimestamp($data->end_time)->toDateTimeString();

        return [
            'plate_number'        => $data->plate_number,
            'unit_code'           => $data->unit_code ?? 'N/A',
            'contractor_name'     => $data->contractor_name ?? 'N/A',
            'contract_number'     => $data->contract_number ? 'عقد ' . $data->contract_number : 'N/A',
            'permission_id'       => $data->permission_id ?? 'N/A',
            'permission_type'     => $data->permission_type ? $lookup[$data->permission_type] : 'N/A',
            'unit_type'           => $data->unit_type ?? 'N/A',
            'waste_type'          => $data->waste_type,
            'net_weight'          => $data->net_weight ? $data->net_weight / 1000 : 'N/A',
            'max_weight'          => $data->max_weight ? $data->max_weight / 1000 : 'N/A',
            'entrance_scale_name' => $data->entrance_scale_name ?? 'N/A',
            'checkin_weight'      => $data->enterance_weight / 1000,
            'exit_scale_name'     => $data->exit_scale_name ?? 'N/A',
            'checkout_weight'     => $data->exit_weight / 1000,
            'waste_weight'        => $data->waste_weight / 1000,
            'checkin_time'        => $start,
            'checkout_time'       => $end,
            'duration'            => Carbon::parse($start)->diff($end)->format('%H:%I:%S'),
        ];
    }
}
