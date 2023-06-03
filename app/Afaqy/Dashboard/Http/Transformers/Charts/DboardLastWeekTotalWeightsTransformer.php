<?php

namespace Afaqy\Dashboard\Http\Transformers\Charts;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class DboardLastWeekTotalWeightsTransformer extends TransformerAbstract
{
    /**
     * @param  mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'day'           => Carbon::parse($data['date'])->format('l'),
            'total_weights' => $data['total_weight'] / 1000,
        ];
    }
}
