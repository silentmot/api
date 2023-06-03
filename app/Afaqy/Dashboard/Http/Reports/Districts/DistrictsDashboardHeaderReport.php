<?php

namespace Afaqy\Dashboard\Http\Reports\Districts;

use ICanBoogie\Inflector;
use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Dashboard\Models\Dashboard;
use Afaqy\Core\Http\Reports\Generator;
use Afaqy\Dashboard\Facades\ReportPeriod;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Dashboard\Models\Filters\DistrictReportFilter;

class DistrictsDashboardHeaderReport extends Report
{
    use Generator;

    /**
     * @var \Illuminate\Http\Request $request
     */
    private $request;

    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function generate()
    {
        $waste_types = $this->query()->get()->pluck('waste_type');

        $data = [
            [
                'prop'  => 'weight_date',
                'name'  => 'التاريخ',
                'unit'  => null,
            ],
            [
                'prop'  => 'district_name',
                'name'  => 'البلديات',
                'unit'  => null,
            ],
        ];

        foreach ($waste_types as $key => $waste_type) {
            $data[] = [
                'prop'  => Inflector::get()->underscore($waste_type),
                'name'  => $waste_type,
                'unit'  => 'ton',
            ];
        }

        $data[] = [
            'prop'  => 'total_weight',
            'name'  => 'الوزن الكلي بالطن',
            'unit'  => 'ton',
        ];

        return $this->returnSuccess('', $data);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        [$start, $end] = ReportPeriod::get($this->request);

        return Dashboard::distinct()->select([
            'waste_type',
        ])
            ->dateBetween($start, $end)
            ->whereNotNull('district_name')
            ->filter($this->request->all(), DistrictReportFilter::class)
            ->tripCompleted()
            ->orderBy('waste_type', 'asc');
    }
}
