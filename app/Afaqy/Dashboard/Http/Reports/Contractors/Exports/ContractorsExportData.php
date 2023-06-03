<?php

namespace Afaqy\Dashboard\Http\Reports\Contractors\Exports;

use Carbon\Carbon;
use ICanBoogie\Inflector;
use Afaqy\Dashboard\Http\Reports\Contractors\ContractorsDashboardHeaderReport;

/**
 * @TODO: need to refact
 */
class ContractorsExportData
{
    /**
     * @var Illuminate\Support\Collection
     */
    public $header;

    /**
     * @var Illuminate\Database\Eloquent\Collection
     */
    public $data;

    /**
     * @param \Illuminate\Database\Eloquent\Collection $data
     * @return void
     */
    public function __construct($data)
    {
        $this->data   = $data;
        $this->header = collect(
            (new ContractorsDashboardHeaderReport(request()))
                ->show()
                ->getData()
                ->data
        );
    }

    /**
     * @return array
     */
    public function header()
    {
        return $this->header->pluck('name')->all();
    }

    /**
     * @return array
     */
    public function data()
    {
        $result        = [];
        $waste_headers = $this->getWasteTypesFromHeader($this->header);

        foreach ($this->data as $key => $trip) {
            $result[$key] = $this->formatRow($waste_headers, $trip);
        }

        return $result;
    }

    /**
     * @param  \Illuminate\Support\Collection $header
     * @return array
     */
    protected function getWasteTypesFromHeader($header)
    {
        $result  = [];
        $exclude = ['contractor_name', 'weight_date', 'total_weight'];

        foreach ($header as $key => $value) {
            if (! in_array($value->prop, $exclude)) {
                $result[] = $value->prop;
            }
        }

        return $result;
    }

    /**
     * @param  array $waste_headers
     * @param  Illuminate\Database\Eloquent\Model $trip
     * @return array
     */
    protected function formatRow($waste_headers, $trip)
    {
        $total_weight = 0;

        $result = [
            $this->getDate($trip->date),
            $trip->contractor_name,
        ];

        $waste_weights = $this->formatWasteWeights($trip->waste_weights);

        foreach ($waste_headers as $waste_header) {
            if (!$weight = $waste_weights[$waste_header] ?? null) {
                $result[] = 'N/A';

                continue;
            }

            $total_weight += $result[] = $weight / 1000;
        }

        $result[] = $total_weight;

        return $result;
    }

    /**
     * @param  int $date
     * @return string
     */
    protected function getDate($date)
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

    /**
     * @param  string $waste_weights
     * @return array
     */
    protected function formatWasteWeights($waste_weights)
    {
        $result = [];

        foreach (explode(',', $waste_weights) as $waste_weight) {
            $data = explode(':', $waste_weight);

            $result[Inflector::get()->underscore($data[0])] = $data[1];
        }

        return $result;
    }
}
