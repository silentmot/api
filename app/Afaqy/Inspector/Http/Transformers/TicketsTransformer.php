<?php

namespace Afaqy\Inspector\Http\Transformers;

use Carbon\Carbon;
use League\Fractal\Resource\Primitive;
use League\Fractal\TransformerAbstract;

class TicketsTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'data',
    ];

    /**
     * @param mixed $data
     * @return array
     */
    public function transform($data): array
    {
        return [
            'created_at'    => Carbon::parse($data[0]['created_at'])->startOfDay()->toIso8601String(),
            'total_records' => $data->count(),
        ];
    }

    /**
     * Transform tickets data.
     *
     * @param mixed $data
     * @return Primitive
     */
    public function includeData($data)
    {
        $tickets = [];
        foreach ($data as $key => $ticket) {
            $tickets[] = [
                'id'                => $data[$key]['id'],
                'neighborhood_name' => $data[$key]['neighborhood_name'],
                'contractor_name'   => $data[$key]['contractor_name'],
                'inspector_name'    => $data[$key]['inspector_name'], // @TODO: it'll return null in inspector list (not used on front)
                'created_at'        => $data[$key]['created_at'],
                'updated_at'        => $data[$key]['updated_at'],
                'status'            => $data[$key]['status'] ?? 'PENDING',
            ];
        }

        return $this->primitive($tickets);
    }
}
