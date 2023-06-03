<?php

namespace Afaqy\Dashboard\Http\Transformers\Violations;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Afaqy\Permission\Lookups\PermissionTypeLookup;

class ViolationsDashboardReportTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        $waste_weight = ($data->permission_type == 'sorting')
            ? $data->exit_weight - $data->enterance_weight
            : $data->enterance_weight - $data->exit_weight;

        $lookup = PermissionTypeLookup::toArray();

        return [
            'date'            => Carbon::fromTimestamp($data->date)->toDateTimeString(),
            'plate_number'    => $data->plate_number,
            'unit_code'       => $data->unit_code,
            'violation_type'  => $data->ar_violation_type,
            'contractor_name' => $data->contractor_name ?? 'N/A',
            'contract_number' => ($data->contract_number) ? 'عقد ' . $data->contract_number : 'N/A',
            'permission_id'   => $data->permission_id ?? 'N/A',
            'permission_type' => ($data->permission_type) ? $lookup[$data->permission_type] : 'N/A',
            'checkin_weight'  => ($data->enterance_weight) ? $data->enterance_weight / 1000 : 'N/A',
            'checkout_weight' => ($data->exit_weight) ? $data->exit_weight / 1000 : 'N/A',
            'waste_weight'    => $waste_weight / 1000,
        ];
    }
}
