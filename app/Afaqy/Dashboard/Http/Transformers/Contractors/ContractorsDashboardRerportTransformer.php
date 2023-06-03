<?php

namespace Afaqy\Dashboard\Http\Transformers\Contractors;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ContractorsDashboardRerportTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        $total_weight = 0;

        $result = [
            'weight_date'     => $this->getDate($data->date),
            'contractor_name' => $data->contractor_name,
        ];

        foreach (explode(',', $data->waste_weights) as $key => $waste_weight) {
            $waste_weight = explode(':', $waste_weight);

            $result[$waste_weight[0]] = $waste_weight[1] / 1000;

            $total_weight += $waste_weight[1];
        }

        $result['total_weight'] = $total_weight / 1000;

        return $result;
    }

    public function getDate($date)
    {
        $type = request()->type ?? 'daily';

        if ($type == 'weekly') {
            [$year, $month, $week] = explode('-', $date);

            return Carbon::now()->setISODate($year, $week)->startOfWeek(Carbon::SATURDAY)->toDateString();
        }

        if ($type == 'monthly') {
            return Carbon::parse($date)->toDateString();
        }

        return $date;
    }
}
