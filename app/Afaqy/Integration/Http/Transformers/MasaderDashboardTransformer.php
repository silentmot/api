<?php

namespace Afaqy\Integration\Http\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class MasaderDashboardTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        preg_match('/[0-9]+/', $data->plate_number, $truck_number);
        preg_match('/[A-Za-z]+/', $data->plate_number, $truck_number_letters);

        return [
            'transaction'          => $data->id,
            'truck_number'         => $truck_number[0],
            'truck_number_letters' => $truck_number_letters[0],
            'transaction_date'     => Carbon::fromTimestamp($data->start_time)->toDateString(),
            'time_in'              => Carbon::fromTimestamp($data->start_time)->toTimeString(),
            'gross_weight'         => $data->weight + $data->net_weight,
            'load_code'            => $data->waste_type_id,
            'company_code'         => $data->contractor_id,
            'time_out'             => Carbon::fromTimestamp($data->end_time)->toTimeString(),
            'tare_weight'          => $data->weight,
            'net_weight'           => $data->net_weight,
        ];
    }
}
